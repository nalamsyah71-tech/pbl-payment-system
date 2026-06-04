<?php

namespace App\Http\Controllers;

use App\Exports\UangSakuExport;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\PembayaranUangSaku;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranUangSakuController extends Controller
{
    public function index(Request $request): View
    {
        $query = PembayaranUangSaku::with('kelas.pelatihan.kejuruan', 'peserta');

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_kuitansi', 'like', "%{$search}%")
                  ->orWhereHas('peserta', fn($p) => $p->where('nama', 'like', "%{$search}%"));
            });
        }

        $pembayarans = $query->latest()->paginate(10)->withQueryString();
        $kelasList   = Kelas::orderBy('nama_kelas')->get();

        return view('pembayaran.uang_saku.index', compact('pembayarans', 'kelasList'));
    }

    public function create(): View
    {
        $kelasList = Kelas::with('pelatihan')->orderBy('nama_kelas')->get();
        return view('pembayaran.uang_saku.create', compact('kelasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => 'required|exists:kelas,id',
            'peserta_id'     => 'required|exists:pesertas,id',
            'no_kuitansi'    => 'required|string|max:100|unique:pembayaran_uang_sakus,no_kuitansi',
            'tgl_spby'       => 'required|date',
            'hari_kehadiran' => 'required|integer|min:1|max:31',
            'total_uang'     => 'required|numeric|min:0',
            'detail_peserta' => 'required',
        ]);

        $peserta = Peserta::findOrFail($request->peserta_id);

        $detailPeserta = [[
            'id'             => $peserta->id,
            'nama'           => $peserta->nama,
            'no_hp'          => $peserta->no_hp,
            'hari_kehadiran' => $request->hari_kehadiran,
            'nominal'        => $request->total_uang,
        ]];

        PembayaranUangSaku::create([
            'kelas_id'       => $request->kelas_id,
            'peserta_id'     => $request->peserta_id,
            'no_kuitansi'    => $request->no_kuitansi,
            'tgl_spby'       => $request->tgl_spby,
            'total_uang'     => $request->total_uang,
            'hari_kehadiran' => $request->hari_kehadiran,
            'detail_peserta' => json_encode($detailPeserta),
        ]);

        return redirect()->route('pembayaran-uang-saku.index')
            ->with('success', 'Pembayaran uang saku berhasil disimpan.');
    }

    public function show(PembayaranUangSaku $pembayaranUangSaku): View
    {
        $pembayaranUangSaku->load('kelas.pelatihan.kejuruan', 'peserta');
        return view('pembayaran.uang_saku.show', compact('pembayaranUangSaku'));
    }

    public function destroy(PembayaranUangSaku $pembayaranUangSaku): RedirectResponse
    {
        $pembayaranUangSaku->delete();
        return redirect()->route('pembayaran-uang-saku.index')
            ->with('success', 'Data pembayaran uang saku berhasil dihapus.');
    }

    public function pdf(PembayaranUangSaku $pembayaranUangSaku)
    {
        $pembayaranUangSaku->load('kelas.pelatihan.kejuruan', 'peserta');
        $pdf = Pdf::loadView('pdf.spby-uang-saku', compact('pembayaranUangSaku'))
            ->setPaper('a4', 'portrait');
        $safeFilename = str_replace(['/', '\\'], '-', $pembayaranUangSaku->no_kuitansi);
        return $pdf->stream('SPPBy-UangSaku-' . $safeFilename . '.pdf');
    }

    public function excel(PembayaranUangSaku $pembayaranUangSaku)
    {
        $pembayaranUangSaku->load('kelas.pelatihan.kejuruan', 'peserta');
        $filename = 'Rekapitulasi-UangSaku-' . str_replace(['/', '\\'], '-', $pembayaranUangSaku->kelas->nama_kelas) . '.xlsx';
        return Excel::download(new UangSakuExport($pembayaranUangSaku), $filename);
    }

    /**
     * PDF per kelas — menggunakan data pembayaran AKTUAL.
     * FIX: pakai route model binding (Kelas $kelas) bukan ($kelasId).
     * FIX: pakai blade view bukan raw HTML.
     * FIX: pakai data payment nyata, bukan peserta list dari kelas.
     */
    public function pdfByKelas(Kelas $kelas)
    {
        $kelas->load('pelatihan.kejuruan');

        // Ambil semua pembayaran uang saku untuk kelas ini
        $pembayaranList = PembayaranUangSaku::with('peserta')
            ->where('kelas_id', $kelas->id)
            ->orderBy('tgl_spby')
            ->get();

        $totalKeseluruhan = $pembayaranList->sum('total_uang');

        $data = [
            'kelas'           => $kelas,
            'pelatihan'       => $kelas->pelatihan,
            'kejuruan'        => $kelas->pelatihan->kejuruan ?? null,
            'pembayaranList'  => $pembayaranList,
            'tanggal_cetak'   => now(),
            'totalKeseluruhan' => $totalKeseluruhan,
        ];

        $pdf = Pdf::loadView('pdf.uang-saku-kelas', $data)->setPaper('a4', 'landscape');
        $filename = 'Daftar-UangSaku-Kelas-' . str_replace(['/', '\\'], '-', $kelas->nama_kelas) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Excel per kelas — menggunakan data pembayaran AKTUAL.
     * FIX: gunakan $kelas->pembayaranUangSakus() bukan ->peserta.
     */
    public function excelByKelas(Kelas $kelas)
    {
        $kelas->load('pelatihan.kejuruan');

        $pembayaranList = PembayaranUangSaku::with('peserta')
            ->where('kelas_id', $kelas->id)
            ->orderBy('tgl_spby')
            ->get();

        $rows = $pembayaranList->map(function ($item, $index) {
            return [
                'no'             => $index + 1,
                'no_kuitansi'    => $item->no_kuitansi,
                'nama'           => $item->peserta?->nama ?? '-',
                'nik'            => $item->peserta?->nik ?? '-',
                'no_hp'          => $item->peserta?->no_hp ?? '-',
                'hari_kehadiran' => $item->hari_kehadiran ?? 0,
                'tarif_per_hari' => PembayaranUangSaku::TARIF_PER_HARI,
                'tgl_spby'       => $item->tgl_spby->format('d/m/Y'),
                'total'          => (float) $item->total_uang,
            ];
        })->toArray();

        $filename = 'Daftar-UangSaku-Kelas-' . str_replace(['/', '\\'], '-', $kelas->nama_kelas) . '.xlsx';

        return Excel::download(
            new class($rows, $kelas) implements
                \Maatwebsite\Excel\Concerns\FromArray,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\WithEvents
            {
                public function __construct(private array $data, private Kelas $kelas) {}

                public function array(): array  { return $this->data; }

                public function headings(): array {
                    return [
                        ['DAFTAR PENERIMA UANG SAKU'],
                        ['Kelas: ' . $this->kelas->nama_kelas . '  |  Pelatihan: ' . ($this->kelas->pelatihan->nama ?? '-')],
                        ['Tanggal Cetak: ' . now()->format('d/m/Y H:i')],
                        [],
                        ['NO', 'NO. KUITANSI', 'NAMA PESERTA', 'NIK', 'NO HP', 'HARI HADIR', 'TARIF/HARI', 'TGL PEMBAYARAN', 'TOTAL (Rp)'],
                    ];
                }

                public function title(): string { return 'Uang Saku - ' . $this->kelas->nama_kelas; }

                public function registerEvents(): array {
                    return [
                        \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $e) {
                            $sheet = $e->sheet->getDelegate();
                            $sheet->mergeCells('A1:I1');
                            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
                            $sheet->getStyle('A5:I5')->getFont()->setBold(true);
                            $lastRow = count($this->data) + 5;
                            $total = array_sum(array_column($this->data, 'total'));
                            $sheet->setCellValue('H' . ($lastRow + 1), 'TOTAL');
                            $sheet->setCellValue('I' . ($lastRow + 1), $total);
                            $sheet->getStyle('H' . ($lastRow+1) . ':I' . ($lastRow+1))->getFont()->setBold(true);
                            $sheet->getStyle('G6:I' . ($lastRow+1))->getNumberFormat()->setFormatCode('#,##0');
                            foreach (range('A', 'I') as $col) {
                                $sheet->getColumnDimension($col)->setAutoSize(true);
                            }
                        }
                    ];
                }
            },
            $filename
        );
    }
}