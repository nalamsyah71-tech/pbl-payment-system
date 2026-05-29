@extends('layouts.app')

@section('title', 'Pembayaran Asuransi')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-gray-800 font-medium">Pembayaran Asuransi</span>
@endsection

@section('content')
<div class="space-y-5">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Pembayaran Asuransi BPJS Ketenagakerjaan</h1>
            <p class="text-sm text-gray-500 mt-0.5">SPPBy premi asuransi peserta pelatihan</p>
        </div>
        <a href="{{ route('pembayaran-asuransi.create') }}" 
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            + Pembayaran Baru
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-5 py-3 text-left w-12">No</th>
                    <th class="px-5 py-3 text-left">No. Kuitansi</th>
                    <th class="px-5 py-3 text-left">Kelas</th>
                    <th class="px-5 py-3 text-center">Jml Peserta</th>
                    <th class="px-5 py-3 text-right">Total Premi</th>
                    <th class="px-5 py-3 text-center">Tanggal</th>
                    <th class="px-5 py-3 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pembayarans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3 font-mono text-xs text-gray-700">{{ $item->no_kuitansi }}</td>
                    <td class="px-5 py-3">{{ $item->kelas->nama_kelas }}</td>
                    <td class="px-5 py-3 text-center font-semibold">{{ $item->jumlah_peserta }} org</td>
                    <td class="px-5 py-3 text-right font-semibold text-blue-700">
                        Rp {{ number_format($item->total_premi, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-3 text-center text-gray-500">{{ $item->tgl_spby->format('d/m/Y') }}</td>
                    <td class="px-5 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('pembayaran-asuransi.show', $item) }}" 
                               class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('pembayaran-asuransi.pdf', $item) }}" target="_blank"
                               class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg" title="PDF">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </a>
                            <a href="{{ route('pembayaran-asuransi.excel', $item) }}"
                               class="p-1.5 text-green-700 hover:bg-green-50 rounded-lg" title="Excel">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </a>
                            <form action="{{ route('pembayaran-asuransi.destroy', $item) }}" method="POST" 
                                  onsubmit="return confirm('Hapus data pembayaran asuransi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg" title="Hapus">
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
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Belum ada data pembayaran asuransi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($pembayarans->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $pembayarans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection