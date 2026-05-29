@extends('layouts.app')
@section('title', 'Kejuruan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-gray-800 font-medium">Kejuruan</span>
@endsection

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Data Kejuruan</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola master data bidang kejuruan</p>
        </div>
        <a href="{{ route('kejuruan.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kejuruan
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 text-left w-12">No</th>
                    <th class="px-6 py-3 text-left">Nama Kejuruan</th>
                    <th class="px-6 py-3 text-center">Jml Pelatihan</th>
                    <th class="px-6 py-3 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kejuruans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $item->nama }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            {{ $item->pelatihans_count }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('kejuruan.edit', $item) }}"
                               class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('kejuruan.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Hapus kejuruan {{ $item->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada data kejuruan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($kejuruans->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $kejuruans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection