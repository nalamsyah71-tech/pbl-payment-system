<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(): View
    {
        $pesertas = Peserta::with('kelas.pelatihan.kejuruan')
            ->latest()
            ->paginate(15);
        return view('peserta.index', compact('pesertas'));
    }

    public function create(): View
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('peserta.create', compact('kelas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => 'required|exists:kelas,id',
            'nik'            => 'required|string|size:16|unique:pesertas,nik',
            'nama'           => 'required|string|max:150',
            'no_hp'          => 'required|string|max:15',
            'bank'           => 'nullable|string|max:50',
            'nomor_rekening' => 'nullable|string|max:30',
            'hari_kehadiran' => 'required|integer|min:0',
        ]);

        Peserta::create($request->all());

        return redirect()->route('peserta.index')
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    // PERBAIKAN: pakai $pesertum
    public function edit(Peserta $pesertum): View
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('peserta.edit', compact('pesertum', 'kelas'));
    }

    // PERBAIKAN: pakai $pesertum
    public function update(Request $request, Peserta $pesertum): RedirectResponse
    {
        $request->validate([
            'kelas_id'       => 'required|exists:kelas,id',
            'nik'            => 'required|string|size:16|unique:pesertas,nik,' . $pesertum->id,
            'nama'           => 'required|string|max:150',
            'no_hp'          => 'required|string|max:15',
            'bank'           => 'nullable|string|max:50',
            'nomor_rekening' => 'nullable|string|max:30',
            'hari_kehadiran' => 'required|integer|min:0',
        ]);

        $pesertum->update($request->all());

        return redirect()->route('peserta.index')
            ->with('success', 'Peserta berhasil diperbarui.');
    }

    // PERBAIKAN: pakai $pesertum
    public function destroy(Peserta $pesertum): RedirectResponse
    {
        $pesertum->delete();
        return redirect()->route('peserta.index')
            ->with('success', 'Peserta berhasil dihapus.');
    }

    public function byKelas(int $kelasId)
    {
        $pesertas = Peserta::where('kelas_id', $kelasId)
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'no_hp', 'bank', 'nomor_rekening', 'hari_kehadiran']);

        return response()->json($pesertas);
    }
}