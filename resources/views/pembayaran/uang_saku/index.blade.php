@extends('layouts.app')
@section('title', 'Pembayaran Uang Saku')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-gray-800 font-medium">Pembayaran Uang Saku</span>
@endsection

@section('content')
<div class="space-y-5">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Pembayaran Uang Saku</h1>
            <p class="text-sm text-gray-500 mt-0.5">SPPBy uang saku harian peserta</p>
        </div>
        <a href="{{ route('pembayaran-uang-saku.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Pembayaran Baru
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">No Kuitansi</th>
                    <th class="px-4 py-3 text-left">Kelas</th>
                    <th class="px-4 py-3 text-right">Total Uang</th>
                    <th class="px-4 py-3 text-center">Tanggal</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $item)
                <tr class="hover:bg-gray-50 border-t">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $item->no_kuitansi }}</td>
                    <td class="px-4 py-3">{{ $item->kelas->nama_kelas }}</td>
                    <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($item->total_uang, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->tgl_spby->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-1">
                            <a href="{{ route('pembayaran-uang-saku.show', $item) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg" title="Detail">🔍</a>
                            <a href="{{ route('pembayaran-uang-saku.pdf', $item) }}" target="_blank" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg" title="PDF">📄</a>
                            <a href="{{ route('pembayaran-uang-saku.excel', $item) }}" class="p-1.5 text-green-700 hover:bg-green-50 rounded-lg" title="Excel">📊</a>
                            <form action="{{ route('pembayaran-uang-saku.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg" title="Hapus">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400">Belum ada data pembayaran uang saku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($pembayarans->hasPages())
        <div class="px-4 py-3 border-t">{{ $pembayarans->links() }}</div>
        @endif
    </div>
</div>
@endsection