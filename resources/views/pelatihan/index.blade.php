@extends('layouts.app')
@section('title', 'Data Pelatihan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-slate-700">Dashboard</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="font-semibold text-slate-700">Pelatihan</span>
@endsection

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Data Pelatihan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola data pelatihan per kejuruan</p>
        </div>
        <a href="{{ route('pelatihan.create') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold px-4 py-2.5 rounded-xl text-white shadow-md hover:shadow-lg active:scale-95"
           style="background: linear-gradient(135deg, #6366f1, #818cf8);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Pelatihan
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-10">No</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kejuruan</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pelatihan</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Kelas</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pelatihans as $item)
                    <tr class="table-row hover:bg-indigo-50/20 transition-colors">
                        <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3.5">
                            <span class="badge bg-violet-100 text-violet-700">{{ $item->kejuruan->nama }}</span>
                        </td>
                        <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $item->nama }}</td>
                        <td class="px-5 py-3.5 text-center hidden sm:table-cell">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $item->kelas->count() }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('pelatihan.edit', $item) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('pelatihan.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pelatihan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-16 text-center text-slate-400">Belum ada data pelatihan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($pelatihans, 'hasPages') && $pelatihans->hasPages())
        <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">{{ $pelatihans->links() }}</div>
        @endif
    </div>
</div>
@endsection