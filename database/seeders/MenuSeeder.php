<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_menu')->insert([
            [
                'id_menu' => 'MN0001',
                'nama_menu' => 'Dashboard',
                'route_name' => 'dashboard.index',
                'icon' => 'fas fa-home',
                'urutan' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0002',
                'nama_menu' => 'Barang',
                'route_name' => 'barang.index',
                'icon' => 'fas fa-box',
                'urutan' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0003',
                'nama_menu' => 'Kategori',
                'route_name' => 'kategori.index',
                'icon' => 'fas fa-tags',
                'urutan' => 3,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0004',
                'nama_menu' => 'Pelanggan',
                'route_name' => 'pelanggan.index',
                'icon' => 'fas fa-users',
                'urutan' => 4,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0005',
                'nama_menu' => 'Transaksi',
                'route_name' => 'transaksi.index',
                'icon' => 'fas fa-cash-register',
                'urutan' => 5,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0006',
                'nama_menu' => 'Purchase Order',
                'route_name' => 'po.index',
                'icon' => 'fas fa-file-invoice',
                'urutan' => 6,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0007',
                'nama_menu' => 'Barang Masuk',
                'route_name' => 'barang-masuk.index',
                'icon' => 'fas fa-truck',
                'urutan' => 7,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0008',
                'nama_menu' => 'History Stok',
                'route_name' => 'history.index',
                'icon' => 'fas fa-history',
                'urutan' => 8,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0009',
                'nama_menu' => 'Stock Opname',
                'route_name' => 'stock-opname.create',
                'icon' => 'fas fa-clipboard-check',
                'urutan' => 9,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0010',
                'nama_menu' => 'Laporan',
                'route_name' => 'laporan.index',
                'icon' => 'fas fa-chart-bar',
                'urutan' => 10,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0011',
                'nama_menu' => 'User',
                'route_name' => 'user.index',
                'icon' => 'fas fa-user-cog',
                'urutan' => 11,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
