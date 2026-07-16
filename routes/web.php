<?php

use App\Http\Controllers\Auth\KonsumenAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PemesananSupplierController;
use App\Http\Controllers\PemesananKonsumenController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\PembayaranHutangController;
use App\Http\Controllers\PenerimaanPiutangController;
use App\Http\Controllers\PesananPublikController;
use App\Http\Controllers\ReturPembelianController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    // Laporan (khusus admin)
    Route::middleware('role:admin')->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
        Route::get('/pembelian', [LaporanController::class, 'pembelian'])->name('pembelian');
        Route::get('/hutang-piutang', [LaporanController::class, 'hutangPiutang'])->name('hutang-piutang');
        Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
    });

    // Manajemen User (khusus admin)
    Route::middleware('role:admin')->group(function () {
        Route::resource('user', UserController::class)->except(['show']);
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('supplier', SupplierController::class);
    Route::resource('konsumen', KonsumenController::class)->parameters([
        'konsumen' => 'konsumen',
    ]);
    Route::resource('barang', BarangController::class);

    // Pemesanan (Planning)
    Route::resource('pemesanan-supplier', PemesananSupplierController::class);
    Route::resource('pemesanan-konsumen', PemesananKonsumenController::class)->parameters([
        'pemesanan-konsumen' => 'pemesanan_konsumen',
    ]);
    
    Route::post('/pemesanan-konsumen/{pemesanan_konsumen}/proses', [PemesananKonsumenController::class, 'proses'])->name('pemesanan-konsumen.proses');

    // Transaksi Pembelian & Penjualan
    Route::resource('pembelian', PembelianController::class)->except(['edit', 'update']);
    Route::resource('penjualan', PenjualanController::class)->except(['edit', 'update']);

    // Cetak Nota
    Route::get('/pembelian/{pembelian}/cetak', [PembelianController::class, 'cetak'])->name('pembelian.cetak');
    Route::get('/penjualan/{penjualan}/cetak', [PenjualanController::class, 'cetak'])->name('penjualan.cetak');
    
    // Hutang & Piutang
    Route::resource('hutang', HutangController::class)->only(['index', 'show']);
    Route::resource('piutang', PiutangController::class)->only(['index', 'show']);

    Route::post('/hutang/{hutang}/bayar', [PembayaranHutangController::class, 'store'])->name('hutang.bayar');
    Route::post('/piutang/{piutang}/terima', [PenerimaanPiutangController::class, 'store'])->name('piutang.terima');

    // Retur
    Route::resource('retur-pembelian', ReturPembelianController::class)->except(['edit', 'update']);
    Route::resource('retur-penjualan', ReturPenjualanController::class)->except(['edit', 'update']);

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth khusus Konsumen (self-service) — pakai prefix "pelanggan" biar tidak tabrakan dengan resource "konsumen" punya staff
Route::middleware('guest:konsumen')->group(function () {
    Route::get('/pelanggan/register', [KonsumenAuthController::class, 'showRegister'])->name('konsumen.register');
    Route::post('/pelanggan/register', [KonsumenAuthController::class, 'register'])->name('konsumen.register.store');
    Route::get('/pelanggan/login', [KonsumenAuthController::class, 'showLogin'])->name('konsumen.login');
    Route::post('/pelanggan/login', [KonsumenAuthController::class, 'login'])->name('konsumen.login.store');
});

Route::post('/pelanggan/logout', [KonsumenAuthController::class, 'logout'])->name('konsumen.logout');

// Self-service order untuk konsumen (wajib login sebagai konsumen)
Route::middleware('auth:konsumen')->group(function () {
    Route::get('/pesan', [PesananPublikController::class, 'create'])->name('pesanan-publik.create');
    Route::post('/pesan', [PesananPublikController::class, 'store'])->name('pesanan-publik.store');
    Route::get('/pesan/sukses/{pemesanan_konsumen}', [PesananPublikController::class, 'success'])->name('pesanan-publik.success');

    Route::get('/pesanan-saya', [PesananPublikController::class, 'riwayat'])->name('pesanan-saya.index');
    Route::get('/pesanan-saya/{pemesanan_konsumen}', [PesananPublikController::class, 'riwayatShow'])->name('pesanan-saya.show');
});

require __DIR__ . '/auth.php';
