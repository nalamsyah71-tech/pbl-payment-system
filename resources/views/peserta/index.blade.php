@extends('layouts.app')
@section('title', 'Data Peserta')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-gray-800 font-medium">Peserta</span>
@endsection

@section('content')
<div class="space-y-5">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Data Peserta</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data peserta pelatihan</p>
        </div>
        <a href="{{ route('peserta.create') }}" 
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Peserta
        </a>
    </div>

    {{-- Statistik singkat --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500">Total Peserta</p>
            <p class="text-2xl font-bold text-gray-800">{{ $pesertas->total() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500">Halaman Ini</p>
            <p class="text-2xl font-bold text-gray-800">{{ $pesertas->count() }}</p>
        </div>
    </div>

    {{-- Tabel Peserta --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4 text-left w-12">No</th>
                        <th class="px-6 py-4 text-left">NIK</th>
                        <th class="px-6 py-4 text-left">Nama Peserta</th>
                        <th class="px-6 py-4 text-left">Kelas</th>
                        <th class="px-6 py-4 text-left">No HP</th>
                        <th class="px-6 py-4 text-center">Hari Hadir</th>
                        <th class="px-6 py-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pesertas as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-gray-500">
                            {{ ($pesertas->currentPage() - 1) * $pesertas->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-600 font-semibold">{{ $item->nik }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-medium">
                                {{ $item->kelas->nama_kelas ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->no_hp }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                {{ $item->hari_kehadiran }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-1">
                                {{-- Tombol Edit --}}
                                <a href="/peserta/{{ $item->id }}/edit" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200" 
                                   title="Edit Peserta">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="/peserta/{{ $item->id }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta {{ $item->nama }}?\n\nData ini tidak dapat dikembalikan!')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200" 
                                            title="Hapus Peserta">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-gray-400 font-medium">Belum ada data peserta</p>
                            <p class="text-gray-400 text-sm mt-1">Silakan tambah peserta baru</p>
                            <a href="{{ route('peserta.create') }}" class="inline-flex items-center gap-2 mt-4 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Peserta Sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pesertas->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $pesertas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection