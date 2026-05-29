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
        // Statistik utama
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

        // Pembayaran terbaru (gabungan 3 jenis, ambil 5 terakhir per jenis)
        $recentPulsa = PembayaranPulsa::with('kelas.pelatihan')
            ->latest()->take(5)->get()
            ->map(fn($p) => [
                'type'        => 'Pulsa',
                'no_kuitansi' => $p->no_kuitansi,
                'kelas'       => $p->kelas->nama_kelas,
                'total'       => $p->total_uang,
                'tgl'         => $p->tgl_spby,
            ]);

        $recentAsuransi = PembayaranAsuransi::with('kelas.pelatihan')
            ->latest()->take(5)->get()
            ->map(fn($p) => [
                'type'        => 'Asuransi',
                'no_kuitansi' => $p->no_kuitansi,
                'kelas'       => $p->kelas->nama_kelas,
                'total'       => $p->total_premi,
                'tgl'         => $p->tgl_spby,
            ]);

        $recentUangSaku = PembayaranUangSaku::with('kelas.pelatihan')
            ->latest()->take(5)->get()
            ->map(fn($p) => [
                'type'        => 'Uang Saku',
                'no_kuitansi' => $p->no_kuitansi,
                'kelas'       => $p->kelas->nama_kelas,
                'total'       => $p->total_uang,
                'tgl'         => $p->tgl_spby,
            ]);

        // Gabung dan urutkan berdasarkan tanggal terbaru
        $recentPayments = $recentPulsa->concat($recentAsuransi)
            ->concat($recentUangSaku)
            ->sortByDesc('tgl')
            ->take(10)
            ->values();

        return view('dashboard', compact('stats', 'recentPayments'));
    }
}