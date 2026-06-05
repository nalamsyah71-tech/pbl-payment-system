@extends('layouts.app')
@section('title', 'Detail Pembayaran Pulsa')
@section('breadcrumb')
    <a href="{{ route('pembayaran-pulsa.index') }}" class="hover:text-gray-700">Pembayaran Pulsa</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Detail</span>
@endsection

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail Pembayaran Pulsa</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $pembayaranPulsa->no_kuitansi }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pembayaran-pulsa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm">Kembali</a>
        </div>
    </div>

    @php
        // Decode detail_peserta jika masih string JSON
        $detailPeserta = $pembayaranPulsa->detail_peserta;
        if (is_string($detailPeserta)) {
            $detailPeserta = json_decode($detailPeserta, true);
        }
        if (!is_array($detailPeserta)) {
            $detailPeserta = [];
        }
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 text-sm border-b pb-3 mb-4">Informasi Pembayaran</h2>
            <div class="space-y-3">
                <div class="flex"><span class="w-32 text-gray-500 text-sm">No. Kuitansi</span><span class="font-mono text-sm">{{ $pembayaranPulsa->no_kuitansi }}</span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Tanggal SPBY</span><span>{{ $pembayaranPulsa->tgl_spby->format('d/m/Y') }}</span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Kelas</span><span>{{ $pembayaranPulsa->kelas->nama_kelas ?? '-' }}</span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Pelatihan</span><span>{{ $pembayaranPulsa->kelas->pelatihan->nama ?? '-' }}</span></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 text-sm border-b pb-3 mb-4">Ringkasan</h2>
            <div class="space-y-2">
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Total Peserta</span><span>{{ count($detailPeserta) }} orang</span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Total Uang</span><span class="text-xl font-bold text-blue-600">Rp {{ number_format($pembayaranPulsa->total_uang, 0, ',', '.') }}</span></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-100">
            <h2 class="font-semibold text-sm">Daftar Penerima Pulsa</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">No HP</th>
                        <th class="px-4 py-2 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detailPeserta as $idx => $p)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $idx + 1 }}</td>
                        <td class="px-4 py-2">{{ $p['nama'] ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $p['no_hp'] ?? '-' }}</td>
                        <td class="px-4 py-2 text-right">Rp {{ number_format($p['nominal'] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada data penerima</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection