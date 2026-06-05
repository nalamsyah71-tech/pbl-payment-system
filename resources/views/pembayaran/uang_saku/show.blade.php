@extends('layouts.app')
@section('title', 'Detail Pembayaran Uang Saku')
@section('breadcrumb')
    <span class="font-semibold text-slate-700">Detail Pembayaran</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h1 class="text-lg font-bold text-slate-800">Detail Pembayaran Uang Saku</h1>
            <p class="text-xs text-slate-500 mt-0.5">No. Kuitansi: {{ $pembayaranUangSaku->no_kuitansi }}</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 rounded-xl p-4">
                    <h2 class="font-semibold text-sm text-slate-700 border-b pb-2 mb-3">Informasi Kelas</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex"><span class="w-28 text-slate-500">Kelas</span><span>{{ $pembayaranUangSaku->kelas->nama_kelas ?? '-' }}</span></div>
                        <div class="flex"><span class="w-28 text-slate-500">Pelatihan</span><span>{{ $pembayaranUangSaku->kelas->pelatihan->nama ?? '-' }}</span></div>
                        <div class="flex"><span class="w-28 text-slate-500">Tanggal SPBY</span><span>{{ \Carbon\Carbon::parse($pembayaranUangSaku->tgl_spby)->format('d/m/Y') }}</span></div>
                    </div>
                </div>
                
                <div class="bg-slate-50 rounded-xl p-4">
                    <h2 class="font-semibold text-sm text-slate-700 border-b pb-2 mb-3">Ringkasan</h2>
                    <div class="space-y-2 text-sm">
                        @php
                            $detailPeserta = $pembayaranUangSaku->detail_peserta;
                            // Jika masih string JSON, decode dulu
                            if (is_string($detailPeserta)) {
                                $detailPeserta = json_decode($detailPeserta, true);
                            }
                            if (!is_array($detailPeserta)) {
                                $detailPeserta = [];
                            }
                        @endphp
                        <div class="flex"><span class="w-28 text-slate-500">Total Peserta</span><span>{{ count($detailPeserta) }} orang</span></div>
                        <div class="flex"><span class="w-28 text-slate-500">Total Uang</span><span class="text-xl font-bold text-blue-600">Rp {{ number_format($pembayaranUangSaku->total_uang, 0, ',', '.') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-slate-100">
            <div class="px-6 py-3 bg-slate-50/50 border-b border-slate-100">
                <h2 class="font-semibold text-sm text-slate-700">Daftar Penerima Uang Saku</h2>
            </div>
            
            @php
                $detailPeserta = $pembayaranUangSaku->detail_peserta;
                if (is_string($detailPeserta)) {
                    $detailPeserta = json_decode($detailPeserta, true);
                }
                if (!is_array($detailPeserta)) {
                    $detailPeserta = [];
                }
            @endphp
            
            @if(count($detailPeserta) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500">Nama Peserta</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500">Hari Hadir</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($detailPeserta as $idx => $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $idx + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $p['nama'] ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $p['hari_kehadiran'] ?? 0 }}</td>
                            <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($p['nominal'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8 text-slate-500 text-sm">
                Tidak ada data peserta
            </div>
            @endif
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 flex justify-between">
            <a href="{{ route('pembayaran-uang-saku.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800">
                ← Kembali
            </a>
            <div class="flex gap-2">
                <a href="{{ route('pembayaran-uang-saku.pdf', $pembayaranUangSaku) }}" class="px-4 py-2 text-sm font-medium bg-red-500 text-white rounded-lg hover:bg-red-600">
                    PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection