<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function index(): View
    {
        $kelas = Kelas::with('pelatihan.kejuruan')
            ->withCount('pesertas')
            ->latest()
            ->paginate(10);
        return view('kelas.index', compact('kelas'));
    }

    public function create(): View
    {
        $pelatihans = Pelatihan::with('kejuruan')->orderBy('nama')->get();
        return view('kelas.create', compact('pelatihans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pelatihan_id' => 'required|exists:pelatihans,id',
            'nama_kelas'   => 'required|string|max:150',
            'tgl_mulai'    => 'required|date',
            'tgl_selesai'  => 'required|date|after_or_equal:tgl_mulai',
            'hari_efektif' => 'required|integer|min:1',
            'mak_pulsa'    => 'nullable|string|max:50',
            'mak_asuransi' => 'nullable|string|max:50',
            'mak_uang_saku'=> 'nullable|string|max:50',
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    // PERBAIKAN: ganti $kelas menjadi $kela
    public function show(Kelas $kela): View
    {
        $kela->load(['pelatihan.kejuruan', 'pesertas']);
        return view('kelas.show', compact('kela'));
    }

    // PERBAIKAN: ganti $kelas menjadi $kela
    public function edit(Kelas $kela): View
    {
        $pelatihans = Pelatihan::with('kejuruan')->orderBy('nama')->get();
        return view('kelas.edit', compact('kela', 'pelatihans'));
    }

    // PERBAIKAN: ganti $kelas menjadi $kela
    public function update(Request $request, Kelas $kela): RedirectResponse
    {
        $request->validate([
            'pelatihan_id' => 'required|exists:pelatihans,id',
            'nama_kelas'   => 'required|string|max:150',
            'tgl_mulai'    => 'required|date',
            'tgl_selesai'  => 'required|date|after_or_equal:tgl_mulai',
            'hari_efektif' => 'required|integer|min:1',
            'mak_pulsa'    => 'nullable|string|max:50',
            'mak_asuransi' => 'nullable|string|max:50',
            'mak_uang_saku'=> 'nullable|string|max:50',
        ]);

        $kela->update($request->all());

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    // PERBAIKAN: ganti $kelas menjadi $kela
    public function destroy(Kelas $kela): RedirectResponse
    {
        if ($kela->pesertas()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kelas yang masih memiliki peserta.');
        }

        $kela->delete();
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}