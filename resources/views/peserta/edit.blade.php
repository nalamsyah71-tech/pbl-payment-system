@extends('layouts.app')
@section('title', 'Edit Peserta')
@section('breadcrumb')
    <a href="{{ route('peserta.index') }}" class="hover:text-gray-700">Peserta</a>
    <span class="mx-2">/</span>
    <span class="font-medium text-gray-800">Edit</span>
@endsection
@section('content')
<div class="max-w-lg">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Edit Peserta: {{ $pesertum->nama }}</h1>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        {{-- PERBAIKAN: URL manual dengan method PUT --}}
        <form action="/peserta/{{ $pesertum->id }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                <select name="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $pesertum->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                <input type="text" name="nik" value="{{ old('nik', $pesertum->nik) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $pesertum->nama) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No HP <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $pesertum->no_hp) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bank</label>
                <select name="bank" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">-- Pilih Bank --</option>
                    <option value="BRI" {{ old('bank', $pesertum->bank) == 'BRI' ? 'selected' : '' }}>BRI</option>
                    <option value="BNI" {{ old('bank', $pesertum->bank) == 'BNI' ? 'selected' : '' }}>BNI</option>
                    <option value="MANDIRI" {{ old('bank', $pesertum->bank) == 'MANDIRI' ? 'selected' : '' }}>Mandiri</option>
                    <option value="BCA" {{ old('bank', $pesertum->bank) == 'BCA' ? 'selected' : '' }}>BCA</option>
                    <option value="BTN" {{ old('bank', $pesertum->bank) == 'BTN' ? 'selected' : '' }}>BTN</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                <input type="text" name="nomor_rekening" value="{{ old('nomor_rekening', $pesertum->nomor_rekening) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hari Kehadiran <span class="text-red-500">*</span></label>
                <input type="number" name="hari_kehadiran" value="{{ old('hari_kehadiran', $pesertum->hari_kehadiran) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Update Peserta
                </button>
                <a href="{{ route('peserta.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection