@extends('layouts.app')
@section('title', 'Detail Pembayaran Pulsa')
@section('breadcrumb')
    <a href="{{ route('pembayaran-pulsa.index') }}" class="hover:text-gray-700">Pembayaran Pulsa</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Detail</span>
@endsection
@section('content')
<div class="space-y-5">
    <div class="flex justify-between"><div><h1 class="text-xl font-bold">Detail Pembayaran Pulsa</h1><p class="text-sm text-gray-500">No. Kuitansi: {{ $pembayaranPulsa->no_kuitansi }}</p></div>
    <div class="flex gap-2"><a href="{{ route('pembayaran-pulsa.pdf', $pembayaranPulsa) }}" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm">📄 PDF</a><a href="{{ route('pembayaran-pulsa.index') }}" class="bg-gray-100 px-3 py-1.5 rounded-lg text-sm">Kembali</a></div></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border p-5"><h2 class="font-semibold text-sm border-b pb-2 mb-3">Informasi SPPBy</h2>
            <div class="space-y-2 text-sm"><div class="flex"><span class="w-32 text-gray-500">No Kuitansi</span><span>{{ $pembayaranPulsa->no_kuitansi }}</span></div>
            <div class="flex"><span class="w-32 text-gray-500">No SK</span><span>{{ $pembayaranPulsa->no_sk ?? '-' }}</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Tanggal SPPBy</span><span>{{ $pembayaranPulsa->tgl_spby->format('d/m/Y') }}</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Kelas</span><span>{{ $pembayaranPulsa->kelas->nama_kelas }}</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Pelatihan</span><span>{{ $pembayaranPulsa->kelas->pelatihan->nama }}</span></div></div>
        </div>
        <div class="bg-white rounded-xl border p-5"><h2 class="font-semibold text-sm border-b pb-2 mb-3">Ringkasan</h2>
            <div class="space-y-2"><div class="flex"><span class="w-32 text-gray-500">Total Peserta</span><span>{{ count($pembayaranPulsa->detail_peserta ?? []) }} orang</span></div>
            <div class="flex"><span class="w-32 text-gray-500">Total Uang</span><span class="text-xl font-bold text-blue-600">Rp {{ number_format($pembayaranPulsa->total_uang, 0, ',', '.') }}</span></div></div>
        </div>
    </div>

    <div class="bg-white rounded-xl border"><div class="px-5 py-3 border-b"><h2 class="font-semibold text-sm">Daftar Penerima Pulsa</h2></div>
        <table class="w-full text-sm"><thead><tr class="bg-gray-50"><th class="px-4 py-2 text-left">No</th><th class="px-4 py-2 text-left">Nama</th><th class="px-4 py-2 text-left">No HP</th><th class="px-4 py-2 text-right">Nominal</th></tr></thead>
        <tbody>@foreach($pembayaranPulsa->detail_peserta ?? [] as $idx => $p)<tr><td class="px-4 py-2">{{ $idx+1 }}</td><td class="px-4 py-2">{{ $p['nama'] }}</td><td class="px-4 py-2">{{ $p['no_hp'] }}</td><td class="px-4 py-2 text-right">Rp {{ number_format($p['nominal'], 0, ',', '.') }}</td></tr>@endforeach</tbody>
        </table>
    </div>
</div>
@endsection