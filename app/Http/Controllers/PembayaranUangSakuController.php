<?php

namespace App\Http\Controllers;

use App\Exports\UangSakuExport;
use App\Models\Kelas;
use App\Models\PembayaranUangSaku;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranUangSakuController extends Controller
{
    public function index(): View
    {
        $pembayarans = PembayaranUangSaku::with('kelas.pelatihan.kejuruan')
            ->latest()->paginate(10);
        return view('pembayaran.uang_saku.index', compact('pembayarans'));
    }

    public function create(): View
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('pembayaran.uang_saku.create', compact('kelas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => 'required|exists:kelas,id',
            'no_kuitansi'    => 'required|string|max:100',
            'tgl_spby'       => 'required|date',
            'detail_peserta' => 'required|array|min:1',
            'total_uang'     => 'required|numeric|min:0',
        ]);

        PembayaranUangSaku::create([
            'kelas_id'       => $request->kelas_id,
            'no_kuitansi'    => $request->no_kuitansi,
            'tgl_spby'       => $request->tgl_spby,
            'total_uang'     => $request->total_uang,
            'detail_peserta' => $request->detail_peserta,
        ]);

        return redirect()->route('pembayaran-uang-saku.index')
            ->with('success', 'Pembayaran uang saku berhasil disimpan.');
    }

    public function show(PembayaranUangSaku $pembayaranUangSaku): View
    {
        $pembayaranUangSaku->load('kelas.pelatihan.kejuruan');
        return view('pembayaran.uang_saku.show', compact('pembayaranUangSaku'));
    }

    public function destroy(PembayaranUangSaku $pembayaranUangSaku): RedirectResponse
    {
        $pembayaranUangSaku->delete();
        return redirect()->route('pembayaran-uang-saku.index')
            ->with('success', 'Data pembayaran uang saku dihapus.');
    }

    public function pdf(PembayaranUangSaku $pembayaranUangSaku)
    {
        $pembayaranUangSaku->load('kelas.pelatihan.kejuruan');
        $pdf = Pdf::loadView('pdf.spby-uang-saku', compact('pembayaranUangSaku'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('SPPBy-UangSaku-' . $pembayaranUangSaku->no_kuitansi . '.pdf');
    }

    public function excel(PembayaranUangSaku $pembayaranUangSaku)
    {
        $pembayaranUangSaku->load('kelas.pelatihan.kejuruan');
        $filename = 'Rekapitulasi-UangSaku-' . $pembayaranUangSaku->kelas->nama_kelas . '.xlsx';
        return Excel::download(new UangSakuExport($pembayaranUangSaku), $filename);
    }
}