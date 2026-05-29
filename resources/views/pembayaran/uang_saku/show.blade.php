@extends('layouts.app')
@section('title', 'Detail Pembayaran Uang Saku')
@section('breadcrumb')
    <a href="{{ route('pembayaran-uang-saku.index') }}" class="hover:text-gray-700">Pembayaran Uang Saku</a>
    <span class="mx-2">/</span>
    <span class="font-medium text-gray-800">Detail</span>
@endsection

@section('content')
<div class="space-y-5">
    <div class="flex justify-between">
        <div>
            <h1 class="text-xl font-bold">Detail Pembayaran Uang Saku</h1>
            <p class="text-sm text-gray-500">No. Kuitansi: {{ $pembayaranUangSaku->no_kuitansi }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pembayaran-uang-saku.pdf', $pembayaranUangSaku) }}" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm">📄 PDF</a>
            <a href="{{ route('pembayaran-uang-saku.index') }}" class="bg-gray-100 px-3 py-1.5 rounded-lg text-sm">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border p-5">
            <h2 class="font-semibold text-sm border-b pb-2 mb-3">Informasi SPPBy</h2>
            <div class="space-y-2 text-sm">
                <div class="flex"><span class="w-32 text-gray-500">No Kuitansi</span><span>{{ $pembayaranUangSaku->no_kuitansi }}</span></div>
                <div class="flex"><span class="w-32 text-gray-500">Tanggal SPPBy</span><span>{{ $pembayaranUangSaku->tgl_spby->format('d/m/Y') }}</span></div>
                <div class="flex"><span class="w-32 text-gray-500">Kelas</span><span>{{ $pembayaranUangSaku->kelas->nama_kelas }}</span></div>
                <div class="flex"><span class="w-32 text-gray-500">Pelatihan</span><span>{{ $pembayaranUangSaku->kelas->pelatihan->nama }}</span></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border p-5">
            <h2 class="font-semibold text-sm border-b pb-2 mb-3">Ringkasan</h2>
            <div class="space-y-2">
                <div class="flex"><span class="w-32 text-gray-500">Total Peserta</span><span>{{ count($pembayaranUangSaku->detail_peserta ?? []) }} orang</span></div>
                <div class="flex"><span class="w-32 text-gray-500">Total Uang</span><span class="text-xl font-bold text-blue-600">Rp {{ number_format($pembayaranUangSaku->total_uang, 0, ',', '.') }}</span></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border">
        <div class="px-5 py-3 border-b"><h2 class="font-semibold text-sm">Daftar Penerima Uang Saku</h2></div>
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50"><th class="px-4 py-2 text-left">No</th><th class="px-4 py-2 text-left">Nama</th><th class="px-4 py-2 text-center">Hari Hadir</th><th class="px-4 py-2 text-right">Nominal</th></tr></thead>
            <tbody>
                @foreach($pembayaranUangSaku->detail_peserta ?? [] as $idx => $p)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $idx+1 }}</td>
                    <td class="px-4 py-2">{{ $p['nama'] }}</td>
                    <td class="px-4 py-2 text-center">{{ $p['hari_kehadiran'] }} hari</td>
                    <td class="px-4 py-2 text-right">Rp {{ number_format($p['nominal'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection