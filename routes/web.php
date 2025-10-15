<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->middleware('web');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->middleware('web');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/password/reset', [App\Http\Controllers\AuthController::class, 'showPasswordResetForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\AuthController::class, 'sendPasswordResetLink'])->name('password.email');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Menu Management (Admin & Waiter)
Route::middleware(['auth', 'role:admin,waiter'])->group(function () {
    Route::resource('menus', MenuController::class);
});

// Table Management (Admin only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('mejas', MejaController::class);
});

// Pelanggan Management (All authenticated)
Route::middleware(['auth'])->group(function () {
    Route::resource('pelanggans', PelangganController::class);
});

// Order Management (Admin & Waiter)
Route::middleware(['auth', 'role:admin,waiter'])->group(function () {
    Route::resource('pesanans', PesananController::class);
});

// Transaction Management (All authenticated)
Route::middleware(['auth'])->group(function () {
    Route::resource('transaksis', TransaksiController::class);
    Route::get('/transaksis/{transaksi}/receipt', [TransaksiController::class, 'printReceipt'])->name('transaksis.receipt');
});

// Reporting (All authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
    Route::get('/laporan/pesanan', [LaporanController::class, 'pesanan'])->name('laporan.pesanan');
    Route::get('/laporan/export/{type}', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/print/{type}', [LaporanController::class, 'printReport'])->name('laporan.print');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
