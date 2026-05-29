<?php

namespace App\Http\Controllers;

use App\Exports\PulsaExport;
use App\Models\Kelas;
use App\Models\PembayaranPulsa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranPulsaController extends Controller
{
    public function index(): View
    {
        $pembayarans = PembayaranPulsa::with('kelas.pelatihan.kejuruan')
            ->latest()->paginate(10);
        return view('pembayaran.pulsa.index', compact('pembayarans'));
    }

    public function create(): View
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('pembayaran.pulsa.create', compact('kelas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => 'required|exists:kelas,id',
            'no_kuitansi'    => 'required|string|max:100',
            'no_sk'          => 'nullable|string|max:150',
            'tgl_spby'       => 'required|date',
            'detail_peserta' => 'required|array|min:1',
            'total_uang'     => 'required|numeric|min:0',
        ]);

        PembayaranPulsa::create([
            'kelas_id'       => $request->kelas_id,
            'no_kuitansi'    => $request->no_kuitansi,
            'no_sk'          => $request->no_sk,
            'tgl_spby'       => $request->tgl_spby,
            'total_uang'     => $request->total_uang,
            'detail_peserta' => $request->detail_peserta,
        ]);

        return redirect()->route('pembayaran-pulsa.index')
            ->with('success', 'Pembayaran pulsa berhasil disimpan.');
    }

    public function show(PembayaranPulsa $pembayaranPulsa): View
    {
        $pembayaranPulsa->load('kelas.pelatihan.kejuruan');
        return view('pembayaran.pulsa.show', compact('pembayaranPulsa'));
    }

    public function destroy(PembayaranPulsa $pembayaranPulsa): RedirectResponse
    {
        $pembayaranPulsa->delete();
        return redirect()->route('pembayaran-pulsa.index')
            ->with('success', 'Data pembayaran pulsa dihapus.');
    }

    /**
     * Generate PDF SPPBy Pulsa
     */
    public function pdf(PembayaranPulsa $pembayaranPulsa)
    {
        $pembayaranPulsa->load('kelas.pelatihan.kejuruan');
        $pdf = Pdf::loadView('pdf.spby-pulsa', compact('pembayaranPulsa'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('SPPBy-Pulsa-' . $pembayaranPulsa->no_kuitansi . '.pdf');
    }

    /**
     * Export Excel daftar penerima pulsa
     */
    public function excel(PembayaranPulsa $pembayaranPulsa)
    {
        $pembayaranPulsa->load('kelas.pelatihan.kejuruan');
        $filename = 'Daftar-Pulsa-' . $pembayaranPulsa->kelas->nama_kelas . '.xlsx';
        return Excel::download(new PulsaExport($pembayaranPulsa), $filename);
    }
}