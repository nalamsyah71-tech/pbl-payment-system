<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KejuruanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PembayaranAsuransiController;
use App\Http\Controllers\PembayaranPulsaController;
use App\Http\Controllers\PembayaranUangSakuController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\PaymentPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('kejuruan', KejuruanController::class)->except(['show']);
Route::resource('pelatihan', PelatihanController::class)->except(['show']);
Route::resource('kelas', KelasController::class);
Route::resource('peserta', PesertaController::class)->except(['show']);
Route::get('api/peserta/by-kelas/{kelas}', [PesertaController::class, 'byKelas'])->name('api.peserta.by-kelas');

Route::prefix('pembayaran/pulsa')->name('pembayaran-pulsa.')->group(function () {
    Route::get('/',           [PembayaranPulsaController::class, 'index'])->name('index');
    Route::get('/create',     [PembayaranPulsaController::class, 'create'])->name('create');
    Route::post('/',          [PembayaranPulsaController::class, 'store'])->name('store');
    Route::get('/{pembayaranPulsa}',        [PembayaranPulsaController::class, 'show'])->name('show');
    Route::delete('/{pembayaranPulsa}',     [PembayaranPulsaController::class, 'destroy'])->name('destroy');
    Route::get('/{pembayaranPulsa}/pdf',    [PembayaranPulsaController::class, 'pdf'])->name('pdf');
    Route::get('/{pembayaranPulsa}/excel',  [PembayaranPulsaController::class, 'excel'])->name('excel');
});

Route::prefix('pembayaran/asuransi')->name('pembayaran-asuransi.')->group(function () {
    Route::get('/',           [PembayaranAsuransiController::class, 'index'])->name('index');
    Route::get('/create',     [PembayaranAsuransiController::class, 'create'])->name('create');
    Route::post('/',          [PembayaranAsuransiController::class, 'store'])->name('store');
    Route::get('/{pembayaranAsuransi}',       [PembayaranAsuransiController::class, 'show'])->name('show');
    Route::delete('/{pembayaranAsuransi}',    [PembayaranAsuransiController::class, 'destroy'])->name('destroy');
    Route::get('/{pembayaranAsuransi}/pdf',   [PembayaranAsuransiController::class, 'pdf'])->name('pdf');
    Route::get('/{pembayaranAsuransi}/excel', [PembayaranAsuransiController::class, 'excel'])->name('excel');
});

Route::prefix('pembayaran/uang-saku')->name('pembayaran-uang-saku.')->group(function () {
    Route::get('/',           [PembayaranUangSakuController::class, 'index'])->name('index');
    Route::get('/create',     [PembayaranUangSakuController::class, 'create'])->name('create');
    Route::post('/',          [PembayaranUangSakuController::class, 'store'])->name('store');
    Route::get('/{pembayaranUangSaku}',       [PembayaranUangSakuController::class, 'show'])->name('show');
    Route::delete('/{pembayaranUangSaku}',    [PembayaranUangSakuController::class, 'destroy'])->name('destroy');
    Route::get('/{pembayaranUangSaku}/pdf',   [PembayaranUangSakuController::class, 'pdf'])->name('pdf');
    Route::get('/{pembayaranUangSaku}/excel', [PembayaranUangSakuController::class, 'excel'])->name('excel');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/payment/create', [PaymentPageController::class, 'create'])->name('payment.create');
    Route::post('/payment/store', [PaymentPageController::class, 'store'])->name('payment.store');
    Route::get('/payment/history', [PaymentPageController::class, 'history'])->name('payment.history');
    Route::get('/payment/success', fn() => view('payment-success'))->name('payment.success');
    Route::get('/payment/failed', fn() => view('payment-failed'))->name('payment.failed');
});

Route::fallback(function () {
    return redirect('/')->with('error', 'Halaman tidak ditemukan!');
});