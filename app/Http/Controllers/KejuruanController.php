<?php

namespace App\Http\Controllers;

use App\Models\Kejuruan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KejuruanController extends Controller
{
    public function index(): View
    {
        $kejuruans = Kejuruan::withCount('pelatihans')->latest()->paginate(10);
        return view('kejuruan.index', compact('kejuruans'));
    }

    public function create(): View
    {
        return view('kejuruan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:150|unique:kejuruans,nama',
        ], [
            'nama.required' => 'Nama kejuruan wajib diisi.',
            'nama.unique'   => 'Nama kejuruan sudah terdaftar.',
        ]);

        Kejuruan::create($request->only('nama'));

        return redirect()->route('kejuruan.index')
            ->with('success', 'Kejuruan berhasil ditambahkan.');
    }

    public function edit(Kejuruan $kejuruan): View
    {
        return view('kejuruan.edit', compact('kejuruan'));
    }

    public function update(Request $request, Kejuruan $kejuruan): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:150|unique:kejuruans,nama,' . $kejuruan->id,
        ]);

        $kejuruan->update($request->only('nama'));

        return redirect()->route('kejuruan.index')
            ->with('success', 'Kejuruan berhasil diperbarui.');
    }

    public function destroy(Kejuruan $kejuruan): RedirectResponse
    {
        // Cegah hapus jika masih ada pelatihan
        if ($kejuruan->pelatihans()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kejuruan yang masih memiliki pelatihan.');
        }

        $kejuruan->delete();
        return redirect()->route('kejuruan.index')
            ->with('success', 'Kejuruan berhasil dihapus.');
    }
}