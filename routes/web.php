<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;

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
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // halaman barang
    Route::get('/form-barang', [BarangController::class, 'create'])->name('form-barang');
    Route::post('/simpan-barang', [BarangController::class, 'simpan_barang'])->name('simpan-barang');
    Route::get('/daftar-barang', [BarangController::class, 'index'])->name('daftar-barang');

    // halaman kategori
    Route::get('/form-kategori', function () {
        return view('Kategori.create');
    })->name('form-kategori');
    Route::post('/simpan-kategori', [KategoriController::class, 'simpan_kategori_barang'])
    ->name('simpan-kategori');

    Route::get('/daftar-kategori', [KategoriController::class, 'index'])
    ->name('daftar-kategori');
});

