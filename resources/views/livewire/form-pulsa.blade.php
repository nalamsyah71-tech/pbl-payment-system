<div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h2 class="font-bold text-lg mb-4">Form Pembayaran Pulsa Internet</h2>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Pilih Kelas <span class="text-red-500">*</span></label>
            <select wire:model="kelas_id" wire:change="updatedKelasId($event.target.value)" class="w-full p-2 border rounded-lg">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->pelatihan->kejuruan->nama }} › {{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">No. Kuitansi <span class="text-red-500">*</span></label>
            <input type="text" wire:model="no_kuitansi" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">No. SK Direktur</label>
            <input type="text" wire:model="no_sk" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tanggal SPPBy <span class="text-red-500">*</span></label>
            <input type="date" wire:model="tgl_spby" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nominal Per Peserta (Rp)</label>
            <div class="flex gap-2">
                <input type="number" wire:model="nominalPerPeserta" class="flex-1 p-2 border rounded-lg">
                <button type="button" wire:click="setNominalSama" class="bg-gray-200 px-4 rounded-lg hover:bg-gray-300">Set Semua</button>
            </div>
        </div>

        <div class="bg-blue-50 p-3 rounded-lg mb-4">
            <strong>Total Pembayaran: Rp {{ number_format($totalUang, 0, ',', '.') }}</strong>
        </div>

        @if(count($detailPeserta) > 0)
            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 text-center">Pilih</th>
                            <th class="p-2 text-left">Nama</th>
                            <th class="p-2 text-left">No HP</th>
                            <th class="p-2 text-right">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailPeserta as $index => $p)
                        <tr class="border-t {{ !$p['checked'] ? 'opacity-50' : '' }}">
                            <td class="p-2 text-center">
                                <input type="checkbox" wire:click="togglePeserta({{ $index }})" {{ $p['checked'] ? 'checked' : '' }}>
                            </td>
                            <td class="p-2">{{ $p['nama'] }}</td>
                            <td class="p-2">{{ $p['no_hp'] }}</td>
                            <td class="p-2 text-right">
                                <input type="number" wire:change="updateNominal({{ $index }}, $event.target.value)" value="{{ $p['nominal'] }}" class="w-28 p-1 text-right border rounded">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- TOMBOL SIMPAN DAN BATAL --}}
            <form action="{{ route('pembayaran-pulsa.store') }}" method="POST" class="mt-4 flex gap-3">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
                <input type="hidden" name="no_kuitansi" value="{{ $no_kuitansi }}">
                <input type="hidden" name="no_sk" value="{{ $no_sk }}">
                <input type="hidden" name="tgl_spby" value="{{ $tgl_spby }}">
                <input type="hidden" name="total_uang" value="{{ $totalUang }}">
                @foreach($detailPeserta as $i => $p)
                    @if($p['checked'])
                        <input type="hidden" name="detail_peserta[{{ $i }}][nama]" value="{{ $p['nama'] }}">
                        <input type="hidden" name="detail_peserta[{{ $i }}][no_hp]" value="{{ $p['no_hp'] }}">
                        <input type="hidden" name="detail_peserta[{{ $i }}][nominal]" value="{{ $p['nominal'] }}">
                    @endif
                @endforeach
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Simpan Pembayaran
                </button>
                <a href="{{ route('pembayaran-pulsa.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
            </form>
        @else
            <div class="text-center py-8 text-gray-500">Pilih kelas untuk melihat daftar peserta</div>
        @endif
    </div>
</div>