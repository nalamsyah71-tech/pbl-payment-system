<div>
    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900">Form Pembayaran Asuransi BPJS</h1>
        <p class="text-sm text-gray-500">Premi Rp {{ number_format(8400, 0, ',', '.') }} per peserta</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-4">
                <h2 class="font-semibold text-gray-800 text-sm border-b pb-3">Data SPPBy</h2>
                
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Pilih Kelas</label>
                    <select wire:model="kelas_id" wire:change="updatedKelasId($event.target.value)" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->pelatihan->kejuruan->nama }} › {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">No. Kuitansi</label>
                    <input type="text" wire:model.defer="no_kuitansi" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">No. SK Direktur</label>
                    <input type="text" wire:model.defer="no_sk" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Tanggal SPPBy</label>
                    <input type="date" wire:model.defer="tgl_spby" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>

                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-xs text-blue-600">Jumlah Peserta</p>
                    <p class="text-2xl font-bold text-blue-800">{{ number_format($jumlahPeserta) }} orang</p>
                    <p class="text-xs text-blue-500 mt-1">Total Premi: Rp {{ number_format($totalPremi, 0, ',', '.') }}</p>
                </div>

                <button type="button" wire:click="simpan" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Simpan Pembayaran
                </button>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 text-sm border-b pb-3 mb-4">Informasi</h2>
            <div class="text-sm text-gray-600 space-y-2">
                <p>✅ Premi BPJS Ketenagakerjaan: <strong>Rp 8.400</strong>/peserta</p>
                <p>✅ Otomatis dihitung berdasarkan jumlah peserta di kelas</p>
                <p>✅ Kelas harus sudah memiliki peserta</p>
            </div>
        </div>
    </div>
</div>