<?php

namespace App\Http\Controllers;

use App\Exports\AsuransiExport;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\PembayaranAsuransi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranAsuransiController extends Controller
{
    public function index(Request $request): View
    {
        $query = PembayaranAsuransi::with('kelas.pelatihan.kejuruan', 'peserta');

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_kuitansi', 'like', "%{$search}%")
                  ->orWhere('no_sk', 'like', "%{$search}%")
                  ->orWhereHas('peserta', fn($p) => $p->where('nama', 'like', "%{$search}%"));
            });
        }

        $pembayarans = $query->latest()->paginate(10)->withQueryString();
        $kelasList   = Kelas::orderBy('nama_kelas')->get();

        return view('pembayaran.asuransi.index', compact('pembayarans', 'kelasList'));
    }

    public function create(): View
    {
        $kelasList = Kelas::with('pelatihan')->orderBy('nama_kelas')->get();
        return view('pembayaran.asuransi.create', compact('kelasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => 'required|exists:kelas,id',
            'peserta_id'     => 'required|exists:pesertas,id',
            'no_sk'          => 'nullable|string|max:150',
            'tgl_spby'       => 'required|date',
            'total_premi'    => 'required|numeric|min:0',
            'detail_peserta' => 'required',
        ]);

        $detailPeserta = $request->detail_peserta;
        if (is_string($detailPeserta)) {
            $detailPeserta = json_decode($detailPeserta, true);
        }

        // BUG FIX: gunakan $no_kuitansi yang di-generate, bukan $request->no_kuitansi
        $lastPayment = PembayaranAsuransi::orderBy('id', 'desc')->first();
        $lastNumber  = $lastPayment ? intval(substr($lastPayment->no_kuitansi, -4)) : 0;
        $no_kuitansi = 'AS/' . date('Ymd') . '/' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        PembayaranAsuransi::create([
            'kelas_id'       => $request->kelas_id,
            'peserta_id'     => $request->peserta_id,
            'no_kuitansi'    => $no_kuitansi,          // ← FIX: pakai variabel lokal, bukan $request
            'no_sk'          => $request->no_sk,
            'tgl_spby'       => $request->tgl_spby,
            'jumlah_peserta' => 1,
            'total_premi'    => $request->total_premi,
            'detail_peserta' => json_encode($detailPeserta),
        ]);

        return redirect()->route('pembayaran-asuransi.index')
            ->with('success', 'Pembayaran asuransi berhasil disimpan.');
    }

    public function show(PembayaranAsuransi $pembayaranAsuransi): View
    {
        $pembayaranAsuransi->load('kelas.pelatihan.kejuruan', 'peserta');
        return view('pembayaran.asuransi.show', compact('pembayaranAsuransi'));
    }

    public function destroy(PembayaranAsuransi $pembayaranAsuransi): RedirectResponse
    {
        $pembayaranAsuransi->delete();
        return redirect()->route('pembayaran-asuransi.index')
            ->with('success', 'Data pembayaran asuransi berhasil dihapus.');
    }

    public function pdf(PembayaranAsuransi $pembayaranAsuransi)
    {
        $pembayaranAsuransi->load('kelas.pelatihan.kejuruan', 'peserta');
        $peserta = $pembayaranAsuransi->kelas->pesertas; // FIX: pesertas bukan peserta
        $pdf = Pdf::loadView('pdf.spby-asuransi', compact('pembayaranAsuransi', 'peserta'))
            ->setPaper('a4', 'portrait');
        $safeFilename = str_replace(['/', '\\'], '-', $pembayaranAsuransi->no_kuitansi);
        return $pdf->stream('SPPBy-Asuransi-' . $safeFilename . '.pdf');
    }

    public function excel(PembayaranAsuransi $pembayaranAsuransi)
    {
        $pembayaranAsuransi->load('kelas.pelatihan.kejuruan');
        $filename = 'Daftar-Asuransi-' . str_replace(['/', '\\'], '-', $pembayaranAsuransi->kelas->nama_kelas) . '.xlsx';
        return Excel::download(new AsuransiExport($pembayaranAsuransi), $filename);
    }

    /**
     * PDF per kelas — menggunakan data pembayaran AKTUAL.
     * FIX: gunakan pesertas (bukan peserta) dan data nyata dari DB.
     */
    public function pdfByKelas(Kelas $kelas)
    {
        $kelas->load('pelatihan.kejuruan');

        // Ambil semua pembayaran asuransi untuk kelas ini
        $pembayaranList = PembayaranAsuransi::with('peserta')
            ->where('kelas_id', $kelas->id)
            ->orderBy('tgl_spby')
            ->get();

        $totalPremi = $pembayaranList->sum('total_premi');

        $data = [
            'kelas'          => $kelas,
            'pelatihan'      => $kelas->pelatihan,
            'kejuruan'       => $kelas->pelatihan->kejuruan ?? null,
            'pembayaranList' => $pembayaranList,
            'tanggal_cetak'  => now(),
            'totalPremi'     => $totalPremi,
        ];

        $pdf = Pdf::loadView('pdf.asuransi-kelas', $data)->setPaper('a4', 'landscape');
        $filename = 'Daftar-Asuransi-Kelas-' . str_replace(['/', '\\'], '-', $kelas->nama_kelas) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Excel per kelas — menggunakan data pembayaran AKTUAL.
     */
    public function excelByKelas(Kelas $kelas)
    {
        $kelas->load('pelatihan.kejuruan');

        $pembayaranList = PembayaranAsuransi::with('peserta')
            ->where('kelas_id', $kelas->id)
            ->orderBy('tgl_spby')
            ->get();

        $rows = $pembayaranList->map(function ($item, $index) {
            return [
                'no'          => $index + 1,
                'no_kuitansi' => $item->no_kuitansi,
                'no_sk'       => $item->no_sk ?? '-',
                'nama'        => $item->peserta?->nama ?? '-',
                'nik'         => $item->peserta?->nik ?? '-',
                'no_hp'       => $item->peserta?->no_hp ?? '-',
                'tgl_spby'    => $item->tgl_spby->format('d/m/Y'),
                'total_premi' => (float) $item->total_premi,
            ];
        })->toArray();

        $filename = 'Daftar-Asuransi-Kelas-' . str_replace(['/', '\\'], '-', $kelas->nama_kelas) . '.xlsx';

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
                        ['DAFTAR PENERIMA ASURANSI BPJS KETENAGAKERJAAN'],
                        ['Kelas: ' . $this->kelas->nama_kelas . '  |  Pelatihan: ' . ($this->kelas->pelatihan->nama ?? '-')],
                        ['Tanggal Cetak: ' . now()->format('d/m/Y H:i')],
                        [],
                        ['NO', 'NO. KUITANSI', 'NO. SK', 'NAMA PESERTA', 'NIK', 'NO HP', 'TGL PEMBAYARAN', 'TOTAL PREMI (Rp)'],
                    ];
                }

                public function title(): string { return 'Asuransi - ' . $this->kelas->nama_kelas; }

                public function registerEvents(): array {
                    return [
                        \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $e) {
                            $sheet = $e->sheet->getDelegate();
                            $sheet->mergeCells('A1:H1');
                            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
                            $sheet->getStyle('A5:H5')->getFont()->setBold(true);
                            $lastRow = count($this->data) + 5;
                            $total = array_sum(array_column($this->data, 'total_premi'));
                            $sheet->setCellValue('G' . ($lastRow + 1), 'TOTAL PREMI');
                            $sheet->setCellValue('H' . ($lastRow + 1), $total);
                            $sheet->getStyle('G' . ($lastRow+1) . ':H' . ($lastRow+1))->getFont()->setBold(true);
                            $sheet->getStyle('H6:H' . ($lastRow+1))->getNumberFormat()->setFormatCode('#,##0');
                            foreach (range('A', 'H') as $col) {
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