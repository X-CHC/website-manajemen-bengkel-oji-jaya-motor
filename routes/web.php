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


//LOGIN / LOGOUT

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');



//HALAMAN BEBAS

Route::get('/', function () {
    return view('welcome');
});



//SEMUA ROUTE YANG BUTUH LOGIN

Route::middleware('auth')->group(function () {


    //DASHBOARD
    //Semua role yang login boleh masuk dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');



    //BARANG
    //Admin & Gudang
    Route::middleware('role:admin,gudang')
        ->prefix('barang')
        ->name('barang.')
        ->group(function () {

            Route::get('/index', [BarangController::class, 'index'])
                ->name('index');

            Route::get('/create', [BarangController::class, 'create'])
                ->name('create');

            Route::post('/', [BarangController::class, 'store'])
                ->name('store');
        });



    //KATEGORI
    //Admin & Gudang
    Route::middleware('role:admin,gudang')
        ->prefix('kategori')
        ->name('kategori.')
        ->group(function () {

            Route::get('/index', [KategoriController::class, 'index'])
                ->name('index');

            Route::get('/create', [KategoriController::class, 'create'])
                ->name('create');

            Route::post('/', [KategoriController::class, 'store'])
                ->name('store');
        });



    //PELANGGAN
    //Admin & Kasir
    Route::middleware('role:admin,kasir')
        ->prefix('pelanggan')
        ->name('pelanggan.')
        ->group(function () {

            Route::get('/index', [PelangganController::class, 'index'])
                ->name('index');

            Route::get('/create', [PelangganController::class, 'create'])
                ->name('create');

            Route::post('/', [PelangganController::class, 'store'])
                ->name('store');
        });



    //TRANSAKSI
    //Admin & Kasir
    Route::middleware('role:admin,kasir')
        ->prefix('transaksi')
        ->name('transaksi.')
        ->group(function () {

            Route::get('/index', [TransaksiController::class, 'index'])
                ->name('index');

            Route::get('/create', [TransaksiController::class, 'create'])
                ->name('create');

            Route::post('/', [TransaksiController::class, 'store'])
                ->name('store');

            Route::get('/cetak/{id}', [TransaksiController::class, 'cetakNota'])
                ->name('cetak');
        });



    //PO
    //Admin & Gudang
    Route::middleware('role:admin,gudang')
        ->prefix('po')
        ->name('po.')
        ->group(function () {

            Route::get('/index', [PoController::class, 'index'])
                ->name('index');

            Route::get('/create', [PoController::class, 'create'])
                ->name('create');

            Route::post('/', [PoController::class, 'store'])
                ->name('store');

            Route::get('/{id}/edit', [PoController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [PoController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [PoController::class, 'destroy'])
                ->name('destroy');
        });



    //BARANG MASUK
    //Admin & Gudang
    Route::middleware('role:admin,gudang')
        ->prefix('barang-masuk')
        ->name('barang-masuk.')
        ->group(function () {

            Route::get('/index', [BarangMasukController::class, 'index'])
                ->name('index');

            Route::get('/create', [BarangMasukController::class, 'create'])
                ->name('create');

            Route::post('/', [BarangMasukController::class, 'store'])
                ->name('store');

            Route::get('/{id}/edit', [BarangMasukController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [BarangMasukController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [BarangMasukController::class, 'destroy'])
                ->name('destroy');
        });



    //HISTORY STOK
    //Admin & Gudang
    Route::middleware('role:admin,gudang')
        ->prefix('history')
        ->name('history.')
        ->group(function () {

            Route::get('/index', [HistoryStokController::class, 'index'])
                ->name('index');
        });



    //LAPORAN
    //Admin & Owner
    Route::middleware('role:admin,owner')
        ->prefix('laporan')
        ->name('laporan.')
        ->group(function () {

            Route::get('/index', [LaporanController::class, 'index'])
                ->name('index');

            Route::post('/pdf', [LaporanController::class, 'exportPdf'])
                ->name('pdf');

            Route::post('/excel', [LaporanController::class, 'exportExcel'])
                ->name('excel');
        });
});
