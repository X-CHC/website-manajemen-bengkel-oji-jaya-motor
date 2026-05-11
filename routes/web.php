<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\HistoryStokController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// halaman bebas
Route::get('/', function () {
    return view('welcome');
});

// halaman yang BUTUH login
Route::middleware('auth')->group(function () {

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // halaman barang
    Route::prefix('barang')->name('barang.')->group(function () {

        Route::get('/index', [BarangController::class, 'index'])
            ->name('index');

        Route::get('/create', [BarangController::class, 'create'])
            ->name('create');

        Route::post('/', [BarangController::class, 'store'])
            ->name('store');
    });

    // halaman kategori
    Route::prefix('kategori')->name('kategori.')->group(function () {

        Route::get('/index', [KategoriController::class, 'index'])
            ->name('index');

        Route::get('/create', [KategoriController::class, 'create'])
            ->name('create');

        Route::post('/', [KategoriController::class, 'store'])
            ->name('store');
    });


    // halaman pelanggan
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {

        Route::get('/create', [PelangganController::class, 'create'])
            ->name('create');

        Route::post('/', [PelangganController::class, 'store'])
            ->name('store');

        Route::get('/index', [PelangganController::class, 'index'])
            ->name('index');
    });

    // halaman transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {

        Route::get('/create', [TransaksiController::class, 'create'])
            ->name('create');

        Route::post('/', [TransaksiController::class, 'store'])
            ->name('store');
    });

    // halaman po
    Route::prefix('po')->name('po.')->group(function () {

        Route::get('/index', [PoController::class, 'index'])
            ->name('index');

        Route::get('/create', [PoController::class, 'create'])
            ->name('create');

        Route::post('/', [PoController::class, 'store'])
            ->name('store');
    });

    // halaman barang masuk
    Route::prefix('barang-masuk')->name('barang-masuk.')->group(function ()
    {

        Route::get('/create', [BarangMasukController::class, 'create'])
            ->name('create');

        Route::post('/', [BarangMasukController::class, 'store'])
            ->name('store');
    });

    // halaman history
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/index', [HistoryStokController::class, 'index'])
            ->name('index');
    });

    // halaman laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/index',[LaporanController::class, 'index']
        )->name('index');

        Route::post('/laporan/pdf',[LaporanController::class, 'exportPdf']
        )->name('pdf');

        Route::post('/laporan/excel',[LaporanController::class, 'exportExcel']
        )->name('excel');
    });





});
