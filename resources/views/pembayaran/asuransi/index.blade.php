@extends('layouts.app')
@section('title', 'Pembayaran Asuransi BPJS')
@section('breadcrumb')
    <span class="text-slate-400">Pembayaran</span>
    <svg class="w-3 h-3 mx-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="font-semibold text-slate-700">Asuransi BPJS</span>
@endsection

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-start gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl flex items-center justify-center text-white flex-shrink-0"
                      style="background: linear-gradient(135deg,#10b981,#059669);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </span>
                Pembayaran Asuransi BPJS
            </h1>
            <p class="text-sm text-slate-500 mt-0.5 ml-10">Kelola data pembayaran premi asuransi peserta</p>
        </div>
        <a href="{{ route('pembayaran-asuransi.create') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold px-4 py-2.5 rounded-xl text-white shadow-md transition-all hover:shadow-lg hover:scale-[1.02] active:scale-95"
           style="background: linear-gradient(135deg, #10b981, #059669);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pembayaran
        </a>
    </div>

    {{-- Filter + Export Panel --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            <span class="text-sm font-bold text-slate-700">Filter & Ekspor</span>
            <span class="text-xs text-slate-400 ml-1">— pilih kelas untuk mengaktifkan tombol ekspor</span>
        </div>

        <div class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[220px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Filter Kelas</label>
                <div class="relative">
                    <select id="filter_kelas"
                            class="w-full appearance-none border border-slate-200 rounded-xl text-sm px-3 py-2.5 pr-9 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:border-emerald-400 transition-all cursor-pointer">
                        <option value="">— Semua Kelas —</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="hidden sm:block w-px h-10 bg-slate-200"></div>

            <div class="flex items-center gap-2">
                <a id="btn_pdf_kelas" href="#"
                   class="export-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          opacity-40 pointer-events-none cursor-not-allowed
                          bg-red-50 text-red-600 border border-red-200
                          hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-md"
                   title="Pilih kelas terlebih dahulu">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <span>PDF Kelas</span>
                </a>

                <a id="btn_excel_kelas" href="#"
                   class="export-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          opacity-40 pointer-events-none cursor-not-allowed
                          bg-emerald-50 text-emerald-600 border border-emerald-200
                          hover:bg-emerald-500 hover:text-white hover:border-emerald-500 hover:shadow-md"
                   title="Pilih kelas terlebih dahulu">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Excel Kelas</span>
                </a>
            </div>

            @if(request('kelas_id'))
            <div class="flex items-center gap-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold px-3 py-2 rounded-xl">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter aktif
                <a href="{{ route('pembayaran-asuransi.index') }}" class="ml-1 text-emerald-400 hover:text-emerald-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50/60">
            <span class="text-sm font-semibold text-slate-600">
                Daftar Pembayaran
                @if(request('kelas_id'))<span class="text-emerald-500">· Kelas Terpilih</span>@endif
            </span>
            <span class="text-xs text-slate-400">{{ $pembayarans->total() }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/40">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Kuitansi</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. SK</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Peserta</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Premi</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembayarans as $item)
                    <tr class="hover:bg-emerald-50/30 transition-colors group">
                        <td class="px-5 py-3.5">
                            <span class="font-mono text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg">
                                {{ $item->no_kuitansi }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-xs text-slate-500">{{ $item->no_sk ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            <span class="text-sm font-semibold text-slate-700">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <span class="text-sm font-semibold text-slate-700">{{ $item->jumlah_peserta ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($item->total_premi, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-xs text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                                {{ \Carbon\Carbon::parse($item->tgl_spby)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('pembayaran-asuransi.show', $item) }}"
                                   class="p-2 text-blue-500 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('pembayaran-asuransi.pdf', $item) }}"
                                   class="p-2 text-red-500 hover:bg-red-50 hover:text-red-700 rounded-lg transition-all" title="Download PDF">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('pembayaran-asuransi.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus pembayaran {{ $item->no_kuitansi }}?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-2 text-rose-500 hover:bg-rose-50 hover:text-rose-700 rounded-lg transition-all" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-semibold">Belum ada data pembayaran asuransi</p>
                                <a href="{{ route('pembayaran-asuransi.create') }}" class="text-sm text-emerald-600 font-semibold hover:text-emerald-700">
                                    + Tambah Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pembayarans->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/40">
            {{ $pembayarans->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
(function() {
    const sel       = document.getElementById('filter_kelas');
    const pdfBtn    = document.getElementById('btn_pdf_kelas');
    const excelBtn  = document.getElementById('btn_excel_kelas');

    const pdfBase   = '{{ route("pembayaran-asuransi.pdf-kelas", ["kelas" => "__ID__"]) }}';
    const excelBase = '{{ route("pembayaran-asuransi.excel-kelas", ["kelas" => "__ID__"]) }}';

    function setEnabled(btn, enabled) {
        if (enabled) {
            btn.classList.remove('opacity-40', 'pointer-events-none', 'cursor-not-allowed');
            btn.classList.add('hover:shadow-md');
            btn.removeAttribute('title');
        } else {
            btn.classList.add('opacity-40', 'pointer-events-none', 'cursor-not-allowed');
            btn.classList.remove('hover:shadow-md');
            btn.setAttribute('title', 'Pilih kelas terlebih dahulu');
            btn.href = '#';
        }
    }

    function updateLinks(id) {
        if (id) {
            pdfBtn.href   = pdfBase.replace('__ID__', id);
            excelBtn.href = excelBase.replace('__ID__', id);
            setEnabled(pdfBtn, true);
            setEnabled(excelBtn, true);
        } else {
            setEnabled(pdfBtn, false);
            setEnabled(excelBtn, false);
        }
    }

    // Init
    updateLinks(sel.value);

    sel.addEventListener('change', function() {
        const id  = this.value;
        const url = new URL(window.location.href);
        if (id) { url.searchParams.set('kelas_id', id); }
        else     { url.searchParams.delete('kelas_id'); }
        window.location.href = url.toString();
    });
})();
</script>
@endsection