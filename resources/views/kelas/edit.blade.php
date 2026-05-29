@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('breadcrumb')
    <a href="{{ route('kelas.index') }}" class="hover:text-gray-700">Kelas</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Edit</span>
@endsection
@section('content')
<div class="max-w-2xl">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Edit Kelas</h1>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        {{-- PERBAIKAN: gunakan route dengan parameter 'kela' --}}
        <form action="{{ route('kelas.update', ['kela' => $kela->id]) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pelatihan <span class="text-red-500">*</span></label>
                <select name="pelatihan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    @foreach($pelatihans as $p)
                        <option value="{{ $p->id }}" {{ old('pelatihan_id', $kela->pelatihan_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->kejuruan->nama }} › {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kela->nama_kelas) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai', $kela->tgl_mulai->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai', $kela->tgl_selesai->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>Hari Efektif</label>
                    <input type="number" name="hari_efektif" value="{{ old('hari_efektif', $kela->hari_efektif) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label>MAK Pulsa</label>
                    <input type="text" name="mak_pulsa" value="{{ old('mak_pulsa', $kela->mak_pulsa) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>MAK Asuransi</label>
                    <input type="text" name="mak_asuransi" value="{{ old('mak_asuransi', $kela->mak_asuransi) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>MAK Uang Saku</label>
                    <input type="text" name="mak_uang_saku" value="{{ old('mak_uang_saku', $kela->mak_uang_saku) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm">Update</button>
                <a href="{{ route('kelas.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection