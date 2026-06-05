@extends('layouts.app')
@section('title', 'Detail Kelas')
@section('breadcrumb')
    <a href="{{ route('kelas.index') }}" class="hover:text-slate-700">Kelas</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="font-semibold text-slate-700">{{ $kela->nama_kelas }}</span>
@endsection

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Detail Kelas</h1>
            <p class="text-sm text-slate-500 mt-0.5">{{ $kela->nama_kelas }} &mdash; {{ $kela->pelatihan->nama }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('kelas.edit', ['kela' => $kela->id]) }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Kelas
            </a>
            <a href="{{ route('peserta.create') }}?kelas_id={{ $kela->id }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                + Tambah Peserta
            </a>
        </div>
    </div>

    {{-- Info Kelas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-5">
            <h2 class="font-semibold text-slate-700 text-sm border-b border-slate-100 pb-3 mb-4">Informasi Kelas</h2>
            <div class="space-y-2.5 text-sm">
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">Pelatihan</span>
                    <span class="text-slate-800 font-medium">{{ $kela->pelatihan->nama }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">Kejuruan</span>
                    <span class="text-slate-800">{{ $kela->pelatihan->kejuruan->nama }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">Periode</span>
                    <span class="text-slate-800">
                        {{ \Carbon\Carbon::parse($kela->tgl_mulai)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($kela->tgl_selesai)->format('d/m/Y') }}
                    </span>
                </div>
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">Hari Efektif</span>
                    <span class="text-slate-800 font-semibold">{{ number_format($kela->hari_efektif) }} hari</span>
                </div>
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">Total Peserta</span>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">{{ $kela->pesertas->count() }}</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-5">
            <h2 class="font-semibold text-slate-700 text-sm border-b border-slate-100 pb-3 mb-4">MAK (Mata Anggaran Kegiatan)</h2>
            <div class="space-y-2.5 text-sm">
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">MAK Pulsa</span>
                    <span class="font-mono text-xs bg-slate-50 px-2 py-0.5 rounded text-slate-700">{{ $kela->mak_pulsa ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">MAK Asuransi</span>
                    <span class="font-mono text-xs bg-slate-50 px-2 py-0.5 rounded text-slate-700">{{ $kela->mak_asuransi ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="w-32 text-slate-500 flex-shrink-0">MAK Uang Saku</span>
                    <span class="font-mono text-xs bg-slate-50 px-2 py-0.5 rounded text-slate-700">{{ $kela->mak_uang_saku ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ✨ FITUR BARU: Export Per Kelas --}}
    <div class="bg-gradient-to-br from-indigo-50 to-slate-50 rounded-xl border border-indigo-100 shadow-sm p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-sm">Export Rekap Per Kelas</h2>
                <p class="text-xs text-slate-500">Export semua data pembayaran untuk kelas ini</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- Pulsa --}}
            <div class="bg-white rounded-xl border border-indigo-100 p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-lg bg-indigo-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">Pulsa Internet</span>
                </div>
                @php $cntPulsa = $kela->pembayaranPulsas()->count(); @endphp
                <p class="text-xs text-slate-500 mb-3">{{ $cntPulsa }} data pembayaran</p>
                <div class="flex gap-2">
                    <a href="{{ route('pembayaran-pulsa.pdf-kelas', $kela->id) }}"
                       class="flex-1 flex items-center justify-center gap-1 bg-red-500 text-white text-xs font-semibold py-2 px-2 rounded-lg hover:bg-red-600 transition-colors @if($cntPulsa == 0) opacity-50 pointer-events-none @endif">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF
                    </a>
                    <a href="{{ route('pembayaran-pulsa.excel-kelas', $kela->id) }}"
                       class="flex-1 flex items-center justify-center gap-1 bg-emerald-500 text-white text-xs font-semibold py-2 px-2 rounded-lg hover:bg-emerald-600 transition-colors @if($cntPulsa == 0) opacity-50 pointer-events-none @endif">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel
                    </a>
                </div>
                @if($cntPulsa == 0)
                <p class="text-xs text-amber-600 mt-2 text-center">Belum ada data pembayaran</p>
                @endif
            </div>

            {{-- Asuransi --}}
            <div class="bg-white rounded-xl border border-emerald-100 p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">Asuransi BPJS</span>
                </div>
                @php $cntAsuransi = $kela->pembayaranAsuransis()->count(); @endphp
                <p class="text-xs text-slate-500 mb-3">{{ $cntAsuransi }} data pembayaran</p>
                <div class="flex gap-2">
                    <a href="{{ route('pembayaran-asuransi.pdf-kelas', $kela->id) }}"
                       class="flex-1 flex items-center justify-center gap-1 bg-red-500 text-white text-xs font-semibold py-2 px-2 rounded-lg hover:bg-red-600 transition-colors @if($cntAsuransi == 0) opacity-50 pointer-events-none @endif">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF
                    </a>
                    <a href="{{ route('pembayaran-asuransi.excel-kelas', $kela->id) }}"
                       class="flex-1 flex items-center justify-center gap-1 bg-emerald-500 text-white text-xs font-semibold py-2 px-2 rounded-lg hover:bg-emerald-600 transition-colors @if($cntAsuransi == 0) opacity-50 pointer-events-none @endif">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel
                    </a>
                </div>
                @if($cntAsuransi == 0)
                <p class="text-xs text-amber-600 mt-2 text-center">Belum ada data pembayaran</p>
                @endif
            </div>

            {{-- Uang Saku --}}
            <div class="bg-white rounded-xl border border-amber-100 p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-lg bg-amber-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">Uang Saku</span>
                </div>
                @php $cntUangSaku = $kela->pembayaranUangSakus()->count(); @endphp
                <p class="text-xs text-slate-500 mb-3">{{ $cntUangSaku }} data pembayaran</p>
                <div class="flex gap-2">
                    <a href="{{ route('pembayaran-uang-saku.pdf-kelas', $kela->id) }}"
                       class="flex-1 flex items-center justify-center gap-1 bg-red-500 text-white text-xs font-semibold py-2 px-2 rounded-lg hover:bg-red-600 transition-colors @if($cntUangSaku == 0) opacity-50 pointer-events-none @endif">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF
                    </a>
                    <a href="{{ route('pembayaran-uang-saku.excel-kelas', $kela->id) }}"
                       class="flex-1 flex items-center justify-center gap-1 bg-emerald-500 text-white text-xs font-semibold py-2 px-2 rounded-lg hover:bg-emerald-600 transition-colors @if($cntUangSaku == 0) opacity-50 pointer-events-none @endif">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel
                    </a>
                </div>
                @if($cntUangSaku == 0)
                <p class="text-xs text-amber-600 mt-2 text-center">Belum ada data pembayaran</p>
                @endif
            </div>

        </div>
    </div>

    {{-- Daftar Peserta --}}
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-slate-800 text-sm">Daftar Peserta</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ $kela->pesertas->count() }} peserta terdaftar</p>
            </div>
            <a href="{{ route('pembayaran-pulsa.create') }}?kelas_id={{ $kela->id }}"
               class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
               + Input Pembayaran
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-xs text-slate-500 font-semibold uppercase">
                        <th class="px-4 py-2.5 text-left">No</th>
                        <th class="px-4 py-2.5 text-left">NIK</th>
                        <th class="px-4 py-2.5 text-left">Nama</th>
                        <th class="px-4 py-2.5 text-left">No HP</th>
                        <th class="px-4 py-2.5 text-left hidden md:table-cell">Bank</th>
                        <th class="px-4 py-2.5 text-right">Hari Hadir</th>
                        <th class="px-4 py-2.5 text-right hidden sm:table-cell">Nominal US</th>
                        <th class="px-4 py-2.5 text-center w-16">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($kela->pesertas as $p)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2.5 text-slate-400 text-xs">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2.5 font-mono text-xs text-slate-600">{{ $p->nik }}</td>
                        <td class="px-4 py-2.5 font-medium text-slate-900">{{ $p->nama }}</td>
                        <td class="px-4 py-2.5 text-slate-500 text-xs">{{ $p->no_hp }}</td>
                        <td class="px-4 py-2.5 text-slate-500 text-xs hidden md:table-cell">{{ $p->bank ?? '-' }}</td>
                        <td class="px-4 py-2.5 text-right font-semibold">{{ $p->hari_kehadiran }} hari</td>
                        <td class="px-4 py-2.5 text-right text-xs font-mono hidden sm:table-cell">
                            Rp {{ number_format($p->hari_kehadiran * 20000, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <a href="{{ route('peserta.edit', $p) }}"
                               class="text-xs text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-slate-400">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Belum ada peserta di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($kela->pesertas->count() > 0)
                <tfoot>
                    <tr class="bg-slate-50">
                        <td colspan="5" class="px-4 py-2.5 text-xs text-slate-500 font-semibold text-right">Total Uang Saku Estimasi:</td>
                        <td class="px-4 py-2.5 text-right font-bold text-amber-700 text-xs">{{ $kela->pesertas->sum('hari_kehadiran') }} hari</td>
                        <td class="px-4 py-2.5 text-right font-bold text-amber-700 text-xs hidden sm:table-cell">
                            Rp {{ number_format($kela->pesertas->sum(fn($p) => $p->hari_kehadiran * 20000), 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection