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
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\CheckStockOpnameMode;

/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| HALAMAN BEBAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| ROUTE YANG BUTUH LOGIN + AKSES MENU DATABASE
|--------------------------------------------------------------------------
| Akses tidak lagi hardcode berdasarkan role di route.
| Semua akses dicek lewat tbl_menu, tbl_role_menu, dan tbl_user_menu.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth',CheckStockOpnameMode::class,'akses.menu',])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->middleware('akses.menu')
            ->name('index');

        Route::get('/2', [DashboardController::class, 'index2'])
            ->middleware('akses.menu:dashboard.index')
            ->name('index2');

        Route::get('/grafik', [DashboardController::class, 'grafikPendapatan2'])
            ->middleware('akses.menu:dashboard.index')
            ->name('grafik');
    });


    /*
    |--------------------------------------------------------------------------
    | BARANG
    |--------------------------------------------------------------------------
    */
    Route::prefix('barang')->name('barang.')->group(function () {

        Route::get('/index', [BarangController::class, 'index'])
            ->name('index');

        Route::get('/create', [BarangController::class, 'create'])
            ->name('create');

        Route::post('/store', [BarangController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [BarangController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [BarangController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [BarangController::class, 'destroy'])
            ->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    */
    Route::prefix('kategori')->name('kategori.')->group(function () {

        Route::get('/index', [KategoriController::class, 'index'])
            ->name('index');

        Route::get('/create', [KategoriController::class, 'create'])
            ->name('create');

        Route::post('/store', [KategoriController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [KategoriController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [KategoriController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [KategoriController::class, 'destroy'])
            ->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | PELANGGAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {

        Route::get('/index', [PelangganController::class, 'index'])
            ->name('index');

        Route::get('/create', [PelangganController::class, 'create'])
            ->name('create');

        Route::post('/store', [PelangganController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [PelangganController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [PelangganController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [PelangganController::class, 'destroy'])
            ->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */
    Route::prefix('transaksi')->name('transaksi.')->group(function () {

        Route::get('/index', [TransaksiController::class, 'index'])
            ->name('index');

        Route::get('/create', [TransaksiController::class, 'create'])
            ->name('create');

        Route::post('/store', [TransaksiController::class, 'store'])
            ->name('store');

        Route::get('/cetak/{id}', [TransaksiController::class, 'cetakNota'])
            ->name('cetak');
    });


    /*
    |--------------------------------------------------------------------------
    | PO
    |--------------------------------------------------------------------------
    */
    Route::prefix('po')->name('po.')->group(function () {

        Route::get('/index', [PoController::class, 'index'])
            ->name('index');

        Route::get('/create', [PoController::class, 'create'])
            ->name('create');

        Route::post('/store', [PoController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [PoController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [PoController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [PoController::class, 'destroy'])
            ->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | BARANG MASUK
    |--------------------------------------------------------------------------
    */
    Route::prefix('barang-masuk')->name('barang-masuk.')->group(function () {

        Route::get('/index', [BarangMasukController::class, 'index'])
            ->name('index');

        Route::get('/create', [BarangMasukController::class, 'create'])
            ->name('create');

        Route::post('/store', [BarangMasukController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [BarangMasukController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [BarangMasukController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [BarangMasukController::class, 'destroy'])
            ->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | HISTORY STOK
    |--------------------------------------------------------------------------
    */
    Route::prefix('history')->name('history.')->group(function () {

        Route::get('/index', [HistoryStokController::class, 'index'])
            ->name('index');

        Route::get('/export-excel', [HistoryStokController::class, 'exportExcel'])
            ->name('export-excel');
    });


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('laporan')->name('laporan.')->group(function () {

        Route::get('/index', [LaporanController::class, 'index'])
            ->name('index');

        Route::post('/pdf', [LaporanController::class, 'exportPdf'])
            ->name('pdf');

        Route::post('/excel', [LaporanController::class, 'exportExcel'])
            ->name('excel');
    });


    /*
    |--------------------------------------------------------------------------
    | STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    Route::prefix('stock-opname')->name('stock-opname.')->group(function () {

        Route::get('/create', [StockOpnameController::class, 'create'])
            ->name('create');

        Route::post('/store', [StockOpnameController::class, 'store'])
            ->name('store');

        Route::post('/mode-on', [StockOpnameController::class, 'modeOn'])
            ->name('mode-on');

        Route::post('/mode-off', [StockOpnameController::class, 'modeOff'])
            ->name('mode-off');
    });


    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */
    Route::prefix('user')->name('user.')->group(function () {

        Route::get('/index', [UserController::class, 'index'])
            ->name('index');

        Route::get('/create', [UserController::class, 'create'])
            ->name('create');

        Route::post('/store', [UserController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [UserController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [UserController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [UserController::class, 'destroy'])
            ->name('destroy');
    });
});
