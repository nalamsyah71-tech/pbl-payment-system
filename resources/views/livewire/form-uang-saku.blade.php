<div>
    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900">Form Pembayaran Uang Saku Harian</h1>
        <p class="text-sm text-gray-500 mt-0.5">Tarif Rp {{ number_format(20000, 0, ',', '.') }} per hari kehadiran</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-4">
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
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Tanggal SPPBy</label>
                    <input type="date" wire:model.defer="tgl_spby" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>

                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-xs text-blue-600 font-medium">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-blue-800 mt-1">Rp {{ number_format($totalUang, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-800 text-sm">Daftar Peserta</h2>
                </div>

                @if(count($detailPeserta) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-500 font-semibold">
                                <th class="px-4 py-2.5 text-center">Pilih</th>
                                <th class="px-4 py-2.5 text-left">Nama</th>
                                <th class="px-4 py-2.5 text-center">Hari Hadir</th>
                                <th class="px-4 py-2.5 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailPeserta as $index => $p)
                            <tr class="hover:bg-gray-50 {{ !$p['checked'] ? 'opacity-50' : '' }}">
                                <td class="px-4 py-2.5 text-center">
                                    <input type="checkbox" wire:click="togglePeserta({{ $index }})" {{ $p['checked'] ? 'checked' : '' }}>
                                </td>
                                <td class="px-4 py-2.5 font-medium">{{ $p['nama'] }}</td>
                                <td class="px-4 py-2.5 text-center">
                                    <input type="number" wire:change="updateHariKehadiran({{ $index }}, $event.target.value)" value="{{ $p['hari_kehadiran'] }}" class="w-20 px-2 py-1 text-center border rounded text-sm">
                                </td>
                                <td class="px-4 py-2.5 text-right">
                                    Rp {{ number_format($p['nominal'], 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-4 border-t border-gray-100 flex gap-3">
                    <form action="{{ route('pembayaran-uang-saku.store') }}" method="POST" class="flex gap-3 w-full">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
                        <input type="hidden" name="no_kuitansi" value="{{ $no_kuitansi }}">
                        <input type="hidden" name="tgl_spby" value="{{ $tgl_spby }}">
                        <input type="hidden" name="total_uang" value="{{ $totalUang }}">
                        @foreach($detailPeserta as $i => $p)
                            @if($p['checked'])
                                <input type="hidden" name="detail_peserta[{{ $i }}][nama]" value="{{ $p['nama'] }}">
                                <input type="hidden" name="detail_peserta[{{ $i }}][hari_kehadiran]" value="{{ $p['hari_kehadiran'] }}">
                                <input type="hidden" name="detail_peserta[{{ $i }}][nominal]" value="{{ $p['nominal'] }}">
                            @endif
                        @endforeach
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium">Simpan Pembayaran</button>
                    </form>
                </div>
                @else
                <div class="px-5 py-16 text-center text-gray-400">Pilih kelas untuk melihat daftar peserta</div>
                @endif
            </div>
        </div>
    </div>
</div>