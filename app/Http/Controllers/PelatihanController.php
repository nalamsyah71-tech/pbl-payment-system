<?php

namespace App\Http\Controllers;

use App\Models\Kejuruan;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PelatihanController extends Controller
{
    public function index(): View
    {
        $pelatihans = Pelatihan::with('kejuruan')
            ->withCount('kelas')
            ->latest()
            ->paginate(10);
        return view('pelatihan.index', compact('pelatihans'));
    }

    public function create(): View
    {
        $kejuruans = Kejuruan::orderBy('nama')->get();
        return view('pelatihan.create', compact('kejuruans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kejuruan_id' => 'required|exists:kejuruans,id',
            'nama'        => 'required|string|max:200',
        ]);

        Pelatihan::create($request->only(['kejuruan_id', 'nama']));

        return redirect()->route('pelatihan.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function edit(Pelatihan $pelatihan): View
    {
        $kejuruans = Kejuruan::orderBy('nama')->get();
        return view('pelatihan.edit', compact('pelatihan', 'kejuruans'));
    }

    public function update(Request $request, Pelatihan $pelatihan): RedirectResponse
    {
        $request->validate([
            'kejuruan_id' => 'required|exists:kejuruans,id',
            'nama'        => 'required|string|max:200',
        ]);

        $pelatihan->update($request->only(['kejuruan_id', 'nama']));

        return redirect()->route('pelatihan.index')
            ->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan): RedirectResponse
    {
        if ($pelatihan->kelas()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus pelatihan yang masih memiliki kelas.');
        }

        $pelatihan->delete();
        return redirect()->route('pelatihan.index')
            ->with('success', 'Pelatihan berhasil dihapus.');
    }
}