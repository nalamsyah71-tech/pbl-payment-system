<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\PembayaranPulsa;
use App\Models\PembayaranAsuransi;
use App\Models\PembayaranUangSaku;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_peserta'     => Peserta::count(),
            'total_kelas'       => Kelas::count(),
            'total_pulsa'       => PembayaranPulsa::sum('total_uang'),
            'total_asuransi'    => PembayaranAsuransi::sum('total_premi'),
            'total_uang_saku'   => PembayaranUangSaku::sum('total_uang'),
            'jumlah_pembayaran' => PembayaranPulsa::count()
                                 + PembayaranAsuransi::count()
                                 + PembayaranUangSaku::count(),
        ];

        // FIX: tambah null-safe operator (?->) agar tidak error jika kelas dihapus
        $recentPulsa = PembayaranPulsa::with('kelas.pelatihan', 'peserta')
            ->latest()->take(5)->get()
            ->map(fn($p) => [
                'type'        => 'Pulsa',
                'no_kuitansi' => $p->no_kuitansi,
                'kelas'       => $p->kelas?->nama_kelas ?? '-',
                'peserta'     => $p->peserta?->nama ?? '-',
                'total'       => $p->total_uang,
                'tgl'         => $p->tgl_spby,
            ]);

        $recentAsuransi = PembayaranAsuransi::with('kelas.pelatihan', 'peserta')
            ->latest()->take(5)->get()
            ->map(fn($p) => [
                'type'        => 'Asuransi',
                'no_kuitansi' => $p->no_kuitansi,
                'kelas'       => $p->kelas?->nama_kelas ?? '-',
                'peserta'     => $p->peserta?->nama ?? '-',
                'total'       => $p->total_premi,
                'tgl'         => $p->tgl_spby,
            ]);

        $recentUangSaku = PembayaranUangSaku::with('kelas.pelatihan', 'peserta')
            ->latest()->take(5)->get()
            ->map(fn($p) => [
                'type'        => 'Uang Saku',
                'no_kuitansi' => $p->no_kuitansi,
                'kelas'       => $p->kelas?->nama_kelas ?? '-',
                'peserta'     => $p->peserta?->nama ?? '-',
                'total'       => $p->total_uang,
                'tgl'         => $p->tgl_spby,
            ]);

        $recentPayments = $recentPulsa->concat($recentAsuransi)
            ->concat($recentUangSaku)
            ->sortByDesc('tgl')
            ->take(10)
            ->values();

        // Rekapitulasi per kelas untuk tabel ringkasan
        $kelasRekap = Kelas::with('pelatihan')
            ->withCount(['pesertas', 'pembayaranPulsas', 'pembayaranAsuransis', 'pembayaranUangSakus'])
            ->withSum('pembayaranPulsas', 'total_uang')
            ->withSum('pembayaranAsuransis', 'total_premi')
            ->withSum('pembayaranUangSakus', 'total_uang')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentPayments', 'kelasRekap'));
    }
}