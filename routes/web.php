<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KejuruanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\PembayaranPulsaController;
use App\Http\Controllers\PembayaranAsuransiController;
use App\Http\Controllers\PembayaranUangSakuController;

// =============================================
// AUTHENTICATION (LOGIN)
// =============================================
Route::get('/login', function () {
    if (Auth::check()) return redirect('/');
    return view('login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->middleware('throttle:10,1'); // FIX: batasi percobaan login 10x per menit

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// =============================================
// PROTECTED ROUTES
// =============================================
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // =============================================
    // MASTER DATA
    // =============================================
    Route::resource('kejuruan', KejuruanController::class)->except(['show']);
    Route::resource('pelatihan', PelatihanController::class)->except(['show']);
    Route::resource('kelas', KelasController::class);
    Route::resource('peserta', PesertaController::class)->except(['show']);

    // API endpoint peserta by kelas
    Route::get('api/peserta/by-kelas/{kelas}', [PesertaController::class, 'byKelas'])
        ->name('api.peserta.by-kelas');

    // =============================================
    // PEMBAYARAN PULSA
    // =============================================
    Route::prefix('pembayaran/pulsa')->name('pembayaran-pulsa.')->group(function () {
        Route::get('/',       [PembayaranPulsaController::class, 'index'])->name('index');
        Route::get('/create', [PembayaranPulsaController::class, 'create'])->name('create');
        Route::post('/',      [PembayaranPulsaController::class, 'store'])->name('store');

        // Kelas routes HARUS sebelum /{id} agar tidak tertangkap wildcard
        Route::get('/kelas/{kelas}/pdf',   [PembayaranPulsaController::class, 'pdfByKelas'])->name('pdf-kelas');
        Route::get('/kelas/{kelas}/excel', [PembayaranPulsaController::class, 'excelByKelas'])->name('excel-kelas');

        Route::get('/{pembayaranPulsa}',         [PembayaranPulsaController::class, 'show'])->name('show');
        Route::get('/{pembayaranPulsa}/edit',    [PembayaranPulsaController::class, 'edit'])->name('edit');    // BARU
        Route::put('/{pembayaranPulsa}',         [PembayaranPulsaController::class, 'update'])->name('update'); // BARU
        Route::delete('/{pembayaranPulsa}',      [PembayaranPulsaController::class, 'destroy'])->name('destroy');
        Route::get('/{pembayaranPulsa}/pdf',     [PembayaranPulsaController::class, 'pdf'])->name('pdf');
        Route::get('/{pembayaranPulsa}/excel',   [PembayaranPulsaController::class, 'excel'])->name('excel');
    });

    // =============================================
    // PEMBAYARAN ASURANSI
    // =============================================
    Route::prefix('pembayaran/asuransi')->name('pembayaran-asuransi.')->group(function () {
        Route::get('/',       [PembayaranAsuransiController::class, 'index'])->name('index');
        Route::get('/create', [PembayaranAsuransiController::class, 'create'])->name('create');
        Route::post('/',      [PembayaranAsuransiController::class, 'store'])->name('store');

        Route::get('/kelas/{kelas}/pdf',   [PembayaranAsuransiController::class, 'pdfByKelas'])->name('pdf-kelas');
        Route::get('/kelas/{kelas}/excel', [PembayaranAsuransiController::class, 'excelByKelas'])->name('excel-kelas');

        Route::get('/{pembayaranAsuransi}',        [PembayaranAsuransiController::class, 'show'])->name('show');
        Route::get('/{pembayaranAsuransi}/edit',   [PembayaranAsuransiController::class, 'edit'])->name('edit');    // BARU
        Route::put('/{pembayaranAsuransi}',        [PembayaranAsuransiController::class, 'update'])->name('update'); // BARU
        Route::delete('/{pembayaranAsuransi}',     [PembayaranAsuransiController::class, 'destroy'])->name('destroy');
        Route::get('/{pembayaranAsuransi}/pdf',    [PembayaranAsuransiController::class, 'pdf'])->name('pdf');
        Route::get('/{pembayaranAsuransi}/excel',  [PembayaranAsuransiController::class, 'excel'])->name('excel');
    });

    // =============================================
    // PEMBAYARAN UANG SAKU
    // =============================================
    Route::prefix('pembayaran/uang-saku')->name('pembayaran-uang-saku.')->group(function () {
        Route::get('/',       [PembayaranUangSakuController::class, 'index'])->name('index');
        Route::get('/create', [PembayaranUangSakuController::class, 'create'])->name('create');
        Route::post('/',      [PembayaranUangSakuController::class, 'store'])->name('store');

        Route::get('/kelas/{kelas}/pdf',   [PembayaranUangSakuController::class, 'pdfByKelas'])->name('pdf-kelas');
        Route::get('/kelas/{kelas}/excel', [PembayaranUangSakuController::class, 'excelByKelas'])->name('excel-kelas');

        Route::get('/{pembayaranUangSaku}',        [PembayaranUangSakuController::class, 'show'])->name('show');
        Route::get('/{pembayaranUangSaku}/edit',   [PembayaranUangSakuController::class, 'edit'])->name('edit');    // BARU
        Route::put('/{pembayaranUangSaku}',        [PembayaranUangSakuController::class, 'update'])->name('update'); // BARU
        Route::delete('/{pembayaranUangSaku}',     [PembayaranUangSakuController::class, 'destroy'])->name('destroy');
        Route::get('/{pembayaranUangSaku}/pdf',    [PembayaranUangSakuController::class, 'pdf'])->name('pdf');
        Route::get('/{pembayaranUangSaku}/excel',  [PembayaranUangSakuController::class, 'excel'])->name('excel');
    });

    // =============================================
    // PAYMENT SYSTEM
    // =============================================
    Route::get('/payment/create',  [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/store',  [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
});

// Fallback
Route::fallback(function () {
    return redirect('/login')->with('error', 'Halaman tidak ditemukan!');
});