@extends('layouts.app')
@section('title', 'Tambah Peserta')
@section('breadcrumb')
    <a href="{{ route('peserta.index') }}" class="hover:text-gray-700">Peserta</a>
    <span class="mx-2">/</span>
    <span class="font-medium text-gray-800">Tambah</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Tambah Peserta Baru</h1>
    
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('peserta.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Pilih Kelas --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select name="kelas_id" 
                    class="w-full px-3 py-2 border @error('kelas_id') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" 
                            {{ old('kelas_id') == $k->id || request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->pelatihan->kejuruan->nama }} › {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- NIK --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    NIK <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nik" value="{{ old('nik') }}" 
                    class="w-full px-3 py-2 border @error('nik') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="16 digit NIK (contoh: 3201010101010001)">
                @error('nik')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}" 
                    class="w-full px-3 py-2 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nama lengkap peserta">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- No HP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nomor HP <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                    class="w-full px-3 py-2 border @error('no_hp') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: 081234567890">
                @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bank dan Rekening (2 kolom) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Bank
                    </label>
                    <select name="bank" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Bank --</option>
                        <option value="BRI" {{ old('bank') == 'BRI' ? 'selected' : '' }}>BRI</option>
                        <option value="BNI" {{ old('bank') == 'BNI' ? 'selected' : '' }}>BNI</option>
                        <option value="MANDIRI" {{ old('bank') == 'MANDIRI' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BCA" {{ old('bank') == 'BCA' ? 'selected' : '' }}>BCA</option>
                        <option value="BTN" {{ old('bank') == 'BTN' ? 'selected' : '' }}>BTN</option>
                        <option value="CIMB" {{ old('bank') == 'CIMB' ? 'selected' : '' }}>CIMB Niaga</option>
                        <option value="DANAMON" {{ old('bank') == 'DANAMON' ? 'selected' : '' }}>Danamon</option>
                        <option value="PERMATA" {{ old('bank') == 'PERMATA' ? 'selected' : '' }}>Permata</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor Rekening
                    </label>
                    <input type="text" name="nomor_rekening" value="{{ old('nomor_rekening') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nomor rekening bank">
                </div>
            </div>

            {{-- Hari Kehadiran --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Hari Kehadiran <span class="text-red-500">*</span>
                </label>
                <input type="number" name="hari_kehadiran" value="{{ old('hari_kehadiran', 0) }}" 
                    class="w-full px-3 py-2 border @error('hari_kehadiran') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Jumlah hari kehadiran (0-30)">
                <p class="text-gray-400 text-xs mt-1">Digunakan untuk menghitung uang saku (Rp 20.000/hari)</p>
                @error('hari_kehadiran')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3 pt-4">
                <button type="submit" 
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Simpan Peserta
                </button>
                <a href="{{ route('peserta.index') }}" 
                    class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection