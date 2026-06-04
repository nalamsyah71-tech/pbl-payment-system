<?php

namespace App\Http\Controllers;

use App\Exports\PulsaExport;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\PembayaranPulsa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranPulsaController extends Controller
{
    public function index(Request $request): View
    {
        $query = PembayaranPulsa::with('kelas.pelatihan.kejuruan', 'peserta');

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

        return view('pembayaran.pulsa.index', compact('pembayarans', 'kelasList'));
    }

    public function create(): View
    {
        $kelasList = Kelas::with('pelatihan')->orderBy('nama_kelas')->get();
        return view('pembayaran.pulsa.create', compact('kelasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'   => 'required|exists:kelas,id',
            'peserta_id' => 'required|exists:pesertas,id',
            'total_uang' => 'required|numeric|min:1000',
            'tgl_spby'   => 'required|date',
        ]);

        $peserta = Peserta::findOrFail($request->peserta_id);

        $detailPeserta = [[
            'nama'    => $peserta->nama,
            'no_hp'   => $peserta->no_hp,
            'nominal' => $request->total_uang,
        ]];

        // Auto-generate no_kuitansi
        $lastPayment = PembayaranPulsa::orderBy('id', 'desc')->first();
        $lastNumber  = $lastPayment ? intval(substr($lastPayment->no_kuitansi, -4)) : 0;
        $no_kuitansi = 'PL/' . date('Ymd') . '/' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $payment = PembayaranPulsa::create([
            'no_kuitansi'   => $no_kuitansi,
            'kelas_id'      => $request->kelas_id,
            'peserta_id'    => $request->peserta_id,
            'total_uang'    => $request->total_uang,
            'tgl_spby'      => $request->tgl_spby,
            'keterangan'    => $request->keterangan,
            'detail_peserta' => json_encode($detailPeserta),
        ]);

        return $payment
            ? redirect()->route('pembayaran-pulsa.index')->with('success', 'Pembayaran pulsa berhasil ditambahkan!')
            : back()->with('error', 'Gagal menyimpan data!')->withInput();
    }

    public function show(PembayaranPulsa $pembayaranPulsa): View
    {
        $pembayaranPulsa->load('kelas.pelatihan.kejuruan', 'peserta');
        return view('pembayaran.pulsa.show', compact('pembayaranPulsa'));
    }

    public function destroy(PembayaranPulsa $pembayaranPulsa): RedirectResponse
    {
        $pembayaranPulsa->delete();
        return redirect()->route('pembayaran-pulsa.index')
            ->with('success', 'Data pembayaran pulsa berhasil dihapus.');
    }

    /** PDF SPPBy individual */
    public function pdf(PembayaranPulsa $pembayaranPulsa)
    {
        $pembayaranPulsa->load(['kelas.pelatihan.kejuruan', 'peserta']);
        $pdf = Pdf::loadView('pdf.spby-pulsa', compact('pembayaranPulsa'))
            ->setPaper('a4', 'portrait');
        $safeFilename = str_replace(['/', '\\'], '-', $pembayaranPulsa->no_kuitansi);
        return $pdf->stream('SPPBy-Pulsa-' . $safeFilename . '.pdf');
    }

    /** Excel individual */
    public function excel(PembayaranPulsa $pembayaranPulsa)
    {
        try {
            $pembayaranPulsa->load('kelas.pelatihan.kejuruan');
            $safeClassName = str_replace(['/', '\\'], '-', $pembayaranPulsa->kelas->nama_kelas);
            return Excel::download(new PulsaExport($pembayaranPulsa), 'Daftar-Pulsa-' . $safeClassName . '.xlsx');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate Excel: ' . $e->getMessage());
        }
    }

    /**
     * PDF per kelas — menggunakan data pembayaran AKTUAL, bukan daftar peserta.
     * FIX: gunakan $kelas->pesertas() bukan ->peserta, dan gunakan data payment nyata.
     */
    public function pdfByKelas(Kelas $kelas)
    {
        $kelas->load('pelatihan.kejuruan');

        // Ambil semua pembayaran pulsa untuk kelas ini beserta peserta
        $pembayaranList = PembayaranPulsa::with('peserta')
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

        $pdf = Pdf::loadView('pdf.pulsa-kelas', $data)->setPaper('a4', 'landscape');
        $filename = 'Daftar-Pulsa-Kelas-' . str_replace(['/', '\\'], '-', $kelas->nama_kelas) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Excel per kelas — menggunakan data pembayaran AKTUAL.
     * FIX: gunakan $kelas->pembayaranPulsas() bukan ->peserta.
     */
    public function excelByKelas(Kelas $kelas)
    {
        $kelas->load('pelatihan.kejuruan');

        $pembayaranList = PembayaranPulsa::with('peserta')
            ->where('kelas_id', $kelas->id)
            ->orderBy('tgl_spby')
            ->get();

        $rows = $pembayaranList->map(function ($item, $index) {
            return [
                'no'           => $index + 1,
                'no_kuitansi'  => $item->no_kuitansi,
                'nama'         => $item->peserta?->nama ?? '-',
                'nik'          => $item->peserta?->nik ?? '-',
                'no_hp'        => $item->peserta?->no_hp ?? '-',
                'tgl_spby'     => $item->tgl_spby->format('d/m/Y'),
                'nominal'      => (float) $item->total_uang,
            ];
        })->toArray();

        $filename = 'Daftar-Pulsa-Kelas-' . str_replace(['/', '\\'], '-', $kelas->nama_kelas) . '.xlsx';

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
                        ['DAFTAR PENERIMA BANTUAN PULSA INTERNET'],
                        ['Kelas: ' . $this->kelas->nama_kelas . '  |  Pelatihan: ' . ($this->kelas->pelatihan->nama ?? '-')],
                        ['Tanggal Cetak: ' . now()->format('d/m/Y H:i')],
                        [],
                        ['NO', 'NO. KUITANSI', 'NAMA PESERTA', 'NIK', 'NO HP', 'TGL PEMBAYARAN', 'NOMINAL (Rp)'],
                    ];
                }

                public function title(): string { return 'Pulsa - ' . $this->kelas->nama_kelas; }

                public function registerEvents(): array {
                    return [
                        \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $e) {
                            $sheet = $e->sheet->getDelegate();
                            $sheet->mergeCells('A1:G1');
                            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
                            $sheet->getStyle('A5:G5')->getFont()->setBold(true);
                            $lastRow = count($this->data) + 5;
                            $total = array_sum(array_column($this->data, 'nominal'));
                            $sheet->setCellValue('F' . ($lastRow + 1), 'TOTAL');
                            $sheet->setCellValue('G' . ($lastRow + 1), $total);
                            $sheet->getStyle('F' . ($lastRow+1) . ':G' . ($lastRow+1))->getFont()->setBold(true);
                            $sheet->getStyle('G6:G' . ($lastRow+1))->getNumberFormat()->setFormatCode('#,##0');
                            foreach (range('A', 'G') as $col) {
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