<?php

namespace App\Http\Controllers;

use App\Exports\AsuransiExport;
use App\Models\Kelas;
use App\Models\PembayaranAsuransi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranAsuransiController extends Controller
{
    public function index(): View
    {
        $pembayarans = PembayaranAsuransi::with('kelas.pelatihan.kejuruan')
            ->latest()->paginate(10);
        return view('pembayaran.asuransi.index', compact('pembayarans'));
    }

    public function create(): View
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('pembayaran.asuransi.create', compact('kelas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => 'required|exists:kelas,id',
            'no_kuitansi'    => 'required|string|max:100',
            'no_sk'          => 'nullable|string|max:150',
            'tgl_spby'       => 'required|date',
            'jumlah_peserta' => 'required|integer|min:1',
            'total_premi'    => 'required|numeric|min:0',
        ]);

        PembayaranAsuransi::create($request->only([
            'kelas_id', 'no_kuitansi', 'no_sk',
            'tgl_spby', 'jumlah_peserta', 'total_premi',
        ]));

        return redirect()->route('pembayaran-asuransi.index')
            ->with('success', 'Pembayaran asuransi berhasil disimpan.');
    }

    public function show(PembayaranAsuransi $pembayaranAsuransi): View
    {
        $pembayaranAsuransi->load('kelas.pelatihan.kejuruan');
        return view('pembayaran.asuransi.show', compact('pembayaranAsuransi'));
    }

    public function destroy(PembayaranAsuransi $pembayaranAsuransi): RedirectResponse
    {
        $pembayaranAsuransi->delete();
        return redirect()->route('pembayaran-asuransi.index')
            ->with('success', 'Data pembayaran asuransi dihapus.');
    }

    public function pdf(PembayaranAsuransi $pembayaranAsuransi)
    {
        $pembayaranAsuransi->load('kelas.pelatihan.kejuruan');
        $peserta = $pembayaranAsuransi->kelas->pesertas;
        $pdf = Pdf::loadView('pdf.spby-asuransi', compact('pembayaranAsuransi', 'peserta'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('SPPBy-Asuransi-' . $pembayaranAsuransi->no_kuitansi . '.pdf');
    }

    public function excel(PembayaranAsuransi $pembayaranAsuransi)
    {
        $pembayaranAsuransi->load('kelas.pelatihan.kejuruan');
        $filename = 'Daftar-Asuransi-' . $pembayaranAsuransi->kelas->nama_kelas . '.xlsx';
        return Excel::download(new AsuransiExport($pembayaranAsuransi), $filename);
    }
}