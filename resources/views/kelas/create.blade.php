@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('breadcrumb')
    <a href="{{ route('kelas.index') }}" class="hover:text-gray-700">Kelas</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Tambah</span>
@endsection
@section('content')
<div class="max-w-2xl">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Tambah Kelas</h1>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('kelas.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pelatihan <span class="text-red-500">*</span></label>
                <select name="pelatihan_id"
                    class="w-full px-3 py-2 border @error('pelatihan_id') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Pelatihan --</option>
                    @foreach($pelatihans as $p)
                        <option value="{{ $p->id }}" {{ old('pelatihan_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->kejuruan->nama }} › {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
                @error('pelatihan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}"
                    class="w-full px-3 py-2 border @error('nama_kelas') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: TKJ-A 2024">
                @error('nama_kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}"
                        class="w-full px-3 py-2 border @error('tgl_mulai') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tgl_mulai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}"
                        class="w-full px-3 py-2 border @error('tgl_selesai') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tgl_selesai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hari Efektif <span class="text-red-500">*</span></label>
                    <input type="number" name="hari_efektif" value="{{ old('hari_efektif', 0) }}" min="1"
                        class="w-full px-3 py-2 border @error('hari_efektif') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('hari_efektif') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">MAK (Mata Anggaran Kegiatan)</p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">MAK Pulsa</label>
                        <input type="text" name="mak_pulsa" value="{{ old('mak_pulsa') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="5210.PBL.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">MAK Asuransi</label>
                        <input type="text" name="mak_asuransi" value="{{ old('mak_asuransi') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="5211.PBL.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">MAK Uang Saku</label>
                        <input type="text" name="mak_uang_saku" value="{{ old('mak_uang_saku') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="5212.PBL.01">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Simpan
                </button>
                <a href="{{ route('kelas.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection