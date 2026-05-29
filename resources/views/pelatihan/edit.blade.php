@extends('layouts.app')
@section('title', 'Edit Pelatihan')
@section('breadcrumb')
    <a href="{{ route('pelatihan.index') }}" class="hover:text-gray-700">Pelatihan</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Edit</span>
@endsection
@section('content')
<div class="max-w-lg">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Edit Pelatihan</h1>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('pelatihan.update', $pelatihan) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kejuruan <span class="text-red-500">*</span></label>
                <select name="kejuruan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    @foreach($kejuruans as $k)
                        <option value="{{ $k->id }}" {{ old('kejuruan_id', $pelatihan->kejuruan_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelatihan <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $pelatihan->nama) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Update</button>
                <a href="{{ route('pelatihan.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection