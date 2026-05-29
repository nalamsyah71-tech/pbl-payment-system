{{-- resources/views/pembayaran/asuransi/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Pembayaran Asuransi')
@section('content')
<div class="space-y-5">
    <div class="flex justify-between"><div><h1 class="text-xl font-bold">Pembayaran Asuransi BPJS</h1></div><a href="{{ route('pembayaran-asuransi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">+ Bayar Asuransi</a></div>
    <div class="bg-white rounded-xl border">
        <table class="w-full text-sm"><thead><tr><th>No</th><th>No Kuitansi</th><th>Kelas</th><th>Jml Peserta</th><th>Total Premi</th><th>Aksi</th></tr></thead>
        <tbody>@forelse($pembayarans as $item)
            <tr><td>{{ $loop->iteration }}</td><td>{{ $item->no_kuitansi }}</td><td>{{ $item->kelas->nama_kelas }}</td><td>{{ $item->jumlah_peserta }}</td><td>Rp {{ number_format($item->total_premi,0,',','.') }}</td>
            <td><div class="flex gap-1"><a href="{{ route('pembayaran-asuransi.show', $item) }}">Detail</a><a href="{{ route('pembayaran-asuransi.pdf', $item) }}">PDF</a><a href="{{ route('pembayaran-asuransi.excel', $item) }}">Excel</a></div></td></tr>
            @empty<tr><td colspan="6" class="text-center py-8">Belum ada data</td></tr>@endforelse
        </tbody></table>{{ $pembayarans->links() }}
    </div>
</div>
@endsection