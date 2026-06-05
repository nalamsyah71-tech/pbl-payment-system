<div>
    <div class="max-w-4xl">
        {{-- Header --}}
        <div class="mb-5">
            <h1 class="text-xl font-extrabold text-slate-800">Form Pembayaran Pulsa Internet</h1>
            <p class="text-sm text-slate-500 mt-0.5">Isi data SPPBy bantuan pulsa internet peserta</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Form Utama --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs text-white font-bold" style="background: linear-gradient(135deg,#6366f1,#818cf8);">1</span>
                        Informasi Pembayaran
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Kelas <span class="text-red-400">*</span></label>
                            <select wire:model="kelas_id" wire:change="updatedKelasId($event.target.value)"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 bg-white transition-all">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->pelatihan->kejuruan->nama }} › {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. Kuitansi <span class="text-red-400">*</span></label>
                            <input type="text" wire:model="no_kuitansi"
                                   class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 font-mono transition-all"
                                   placeholder="Contoh: KU-001/2024">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal SPPBy <span class="text-red-400">*</span></label>
                            <input type="date" wire:model="tgl_spby"
                                   class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-all">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. SK Direktur</label>
                            <input type="text" wire:model="no_sk"
                                   class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-all"
                                   placeholder="Nomor SK (opsional)">
                        </div>
                    </div>
                </div>

                {{-- Nominal & Peserta --}}
                @if(count($detailPeserta) > 0)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs text-white font-bold" style="background: linear-gradient(135deg,#6366f1,#818cf8);">2</span>
                        Nominal & Daftar Peserta
                    </h2>

                    {{-- Set nominal cepat --}}
                    <div class="flex gap-2 mb-4">
                        <div class="flex-1 relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-500">Rp</span>
                            <input type="number" wire:model="nominalPerPeserta"
                                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-all"
                                   placeholder="Nominal per peserta">
                        </div>
                        <button type="button" wire:click="setNominalSama"
                                class="px-4 py-2.5 text-sm font-semibold bg-indigo-50 text-indigo-700 rounded-xl hover:bg-indigo-100 transition-colors border border-indigo-200">
                            Set Semua
                        </button>
                    </div>

                    {{-- Tabel peserta --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="px-3 py-2.5 text-center text-xs font-semibold text-slate-500 w-12">✓</th>
                                    <th class="px-3 py-2.5 text-left text-xs font-semibold text-slate-500">Nama Peserta</th>
                                    <th class="px-3 py-2.5 text-left text-xs font-semibold text-slate-500 hidden sm:table-cell">No. HP</th>
                                    <th class="px-3 py-2.5 text-right text-xs font-semibold text-slate-500">Nominal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($detailPeserta as $index => $p)
                                <tr class="{{ !$p['checked'] ? 'opacity-40' : '' }} transition-opacity hover:bg-slate-50">
                                    <td class="px-3 py-2.5 text-center">
                                        <input type="checkbox"
                                               wire:click="togglePeserta({{ $index }})"
                                               {{ $p['checked'] ? 'checked' : '' }}
                                               class="w-4 h-4 rounded accent-indigo-600 cursor-pointer">
                                    </td>
                                    <td class="px-3 py-2.5 font-medium text-slate-800 text-xs">{{ $p['nama'] }}</td>
                                    <td class="px-3 py-2.5 text-slate-500 text-xs hidden sm:table-cell">{{ $p['no_hp'] }}</td>
                                    <td class="px-3 py-2.5 text-right">
                                        <input type="number"
                                               wire:change="updateNominal({{ $index }}, $event.target.value)"
                                               value="{{ $p['nominal'] }}"
                                               {{ !$p['checked'] ? 'disabled' : '' }}
                                               class="w-28 px-2 py-1 text-right text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 font-semibold">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @elseif($kelas_id)
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
                    <svg class="w-10 h-10 text-amber-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-amber-700 font-semibold text-sm">Belum ada peserta di kelas ini</p>
                </div>
                @else
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-8 text-center">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-slate-500 font-semibold text-sm">Pilih kelas terlebih dahulu</p>
                    <p class="text-slate-400 text-xs mt-1">Daftar peserta akan muncul otomatis</p>
                </div>
                @endif
            </div>

            {{-- Summary Panel --}}
            <div class="space-y-4">
                {{-- Total --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sticky top-6">
                    <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-4">Ringkasan</h3>

                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Total Peserta Dipilih</span>
                            <span class="font-bold text-slate-800">{{ collect($detailPeserta)->where('checked',true)->count() }} orang</span>
                        </div>
                        <div class="border-t border-slate-100 pt-3">
                            <p class="text-xs text-slate-500 mb-1">Total Pembayaran</p>
                            <p class="text-2xl font-extrabold text-indigo-600">Rp {{ number_format($totalUang,0,',','.') }}</p>
                        </div>
                    </div>

                    @if(count($detailPeserta) > 0)
                    <form action="{{ route('pembayaran-pulsa.store') }}" method="POST" class="space-y-2">
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
                        <button type="submit"
                                class="w-full py-2.5 text-sm font-bold text-white rounded-xl transition-all hover:shadow-lg active:scale-95"
                                style="background: linear-gradient(135deg, #6366f1, #818cf8);">
                            Simpan Pembayaran
                        </button>
                        <a href="{{ route('pembayaran-pulsa.index') }}"
                           class="block w-full py-2.5 text-sm font-semibold text-slate-600 text-center rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors">
                            Batal
                        </a>
                    </form>
                    @else
                    <a href="{{ route('pembayaran-pulsa.index') }}"
                       class="block w-full py-2.5 text-sm font-semibold text-slate-600 text-center rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors">
                        Kembali
                    </a>
                    @endif
                </div>

                {{-- Info --}}
                <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4">
                    <p class="text-xs font-semibold text-indigo-700 mb-2">ℹ️ Petunjuk</p>
                    <ul class="text-xs text-indigo-600 space-y-1">
                        <li>• Pilih kelas untuk memuat peserta</li>
                        <li>• Centang peserta yang akan dibayarkan</li>
                        <li>• Klik "Set Semua" untuk nominal seragam</li>
                        <li>• Nominal bisa diubah per peserta</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>