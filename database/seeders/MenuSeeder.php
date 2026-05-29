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

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0001',
                'nama_menu' => 'Dashboard',
                'route_name' => 'dashboard.index',
                'icon' => 'fas fa-home',
                'urutan' => 1,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | BARANG - AKSES DETAIL
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0002',
                'nama_menu' => 'List Barang',
                'route_name' => 'barang.index',
                'icon' => 'fas fa-box',
                'urutan' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0003',
                'nama_menu' => 'Tambah Barang',
                'route_name' => 'barang.create',
                'icon' => 'fas fa-box',
                'urutan' => 3,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0004',
                'nama_menu' => 'Simpan Barang',
                'route_name' => 'barang.store',
                'icon' => 'fas fa-box',
                'urutan' => 4,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0005',
                'nama_menu' => 'Edit Barang',
                'route_name' => 'barang.edit',
                'icon' => 'fas fa-box',
                'urutan' => 5,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0006',
                'nama_menu' => 'Update Barang',
                'route_name' => 'barang.update',
                'icon' => 'fas fa-box',
                'urutan' => 6,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0007',
                'nama_menu' => 'Hapus Barang',
                'route_name' => 'barang.destroy',
                'icon' => 'fas fa-box',
                'urutan' => 7,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | KATEGORI
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0008',
                'nama_menu' => 'List Kategori',
                'route_name' => 'kategori.index',
                'icon' => 'fas fa-tags',
                'urutan' => 8,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0009',
                'nama_menu' => 'Tambah Kategori',
                'route_name' => 'kategori.create',
                'icon' => 'fas fa-tags',
                'urutan' => 9,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0010',
                'nama_menu' => 'Simpan Kategori',
                'route_name' => 'kategori.store',
                'icon' => 'fas fa-tags',
                'urutan' => 10,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0011',
                'nama_menu' => 'Edit Kategori',
                'route_name' => 'kategori.edit',
                'icon' => 'fas fa-tags',
                'urutan' => 11,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0012',
                'nama_menu' => 'Update Kategori',
                'route_name' => 'kategori.update',
                'icon' => 'fas fa-tags',
                'urutan' => 12,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0013',
                'nama_menu' => 'Hapus Kategori',
                'route_name' => 'kategori.destroy',
                'icon' => 'fas fa-tags',
                'urutan' => 13,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | TRANSAKSI
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0014',
                'nama_menu' => 'List Transaksi',
                'route_name' => 'transaksi.index',
                'icon' => 'fas fa-cash-register',
                'urutan' => 14,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0015',
                'nama_menu' => 'Buat Transaksi',
                'route_name' => 'transaksi.create',
                'icon' => 'fas fa-cash-register',
                'urutan' => 15,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0016',
                'nama_menu' => 'Simpan Transaksi',
                'route_name' => 'transaksi.store',
                'icon' => 'fas fa-cash-register',
                'urutan' => 16,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0017',
                'nama_menu' => 'Cetak Nota',
                'route_name' => 'transaksi.cetak',
                'icon' => 'fas fa-print',
                'urutan' => 17,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | LAPORAN
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0018',
                'nama_menu' => 'Lihat Laporan',
                'route_name' => 'laporan.index',
                'icon' => 'fas fa-chart-bar',
                'urutan' => 18,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0019',
                'nama_menu' => 'Export PDF Laporan',
                'route_name' => 'laporan.pdf',
                'icon' => 'fas fa-file-pdf',
                'urutan' => 19,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0020',
                'nama_menu' => 'Export Excel Laporan',
                'route_name' => 'laporan.excel',
                'icon' => 'fas fa-file-excel',
                'urutan' => 20,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | PELANGGAN
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0021',
                'nama_menu' => 'List Pelanggan',
                'route_name' => 'pelanggan.index',
                'icon' => 'fas fa-users',
                'urutan' => 21,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0022',
                'nama_menu' => 'Tambah Pelanggan',
                'route_name' => 'pelanggan.create',
                'icon' => 'fas fa-users',
                'urutan' => 22,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0023',
                'nama_menu' => 'Simpan Pelanggan',
                'route_name' => 'pelanggan.store',
                'icon' => 'fas fa-users',
                'urutan' => 23,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0024',
                'nama_menu' => 'Edit Pelanggan',
                'route_name' => 'pelanggan.edit',
                'icon' => 'fas fa-users',
                'urutan' => 24,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0025',
                'nama_menu' => 'Update Pelanggan',
                'route_name' => 'pelanggan.update',
                'icon' => 'fas fa-users',
                'urutan' => 25,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0026',
                'nama_menu' => 'Hapus Pelanggan',
                'route_name' => 'pelanggan.destroy',
                'icon' => 'fas fa-users',
                'urutan' => 26,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | PURCHASE ORDER
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0027',
                'nama_menu' => 'List PO',
                'route_name' => 'po.index',
                'icon' => 'fas fa-file-invoice',
                'urutan' => 27,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0028',
                'nama_menu' => 'Buat PO',
                'route_name' => 'po.create',
                'icon' => 'fas fa-file-invoice',
                'urutan' => 28,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0029',
                'nama_menu' => 'Simpan PO',
                'route_name' => 'po.store',
                'icon' => 'fas fa-file-invoice',
                'urutan' => 29,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0030',
                'nama_menu' => 'Edit PO',
                'route_name' => 'po.edit',
                'icon' => 'fas fa-file-invoice',
                'urutan' => 30,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0031',
                'nama_menu' => 'Update PO',
                'route_name' => 'po.update',
                'icon' => 'fas fa-file-invoice',
                'urutan' => 31,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0032',
                'nama_menu' => 'Hapus PO',
                'route_name' => 'po.destroy',
                'icon' => 'fas fa-file-invoice',
                'urutan' => 32,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | BARANG MASUK
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0033',
                'nama_menu' => 'List Barang Masuk',
                'route_name' => 'barang-masuk.index',
                'icon' => 'fas fa-truck',
                'urutan' => 33,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0034',
                'nama_menu' => 'Tambah Barang Masuk',
                'route_name' => 'barang-masuk.create',
                'icon' => 'fas fa-truck',
                'urutan' => 34,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0035',
                'nama_menu' => 'Simpan Barang Masuk',
                'route_name' => 'barang-masuk.store',
                'icon' => 'fas fa-truck',
                'urutan' => 35,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0036',
                'nama_menu' => 'Edit Barang Masuk',
                'route_name' => 'barang-masuk.edit',
                'icon' => 'fas fa-truck',
                'urutan' => 36,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0037',
                'nama_menu' => 'Update Barang Masuk',
                'route_name' => 'barang-masuk.update',
                'icon' => 'fas fa-truck',
                'urutan' => 37,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0038',
                'nama_menu' => 'Hapus Barang Masuk',
                'route_name' => 'barang-masuk.destroy',
                'icon' => 'fas fa-truck',
                'urutan' => 38,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | HISTORY STOK
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0039',
                'nama_menu' => 'Lihat History Stok',
                'route_name' => 'history.index',
                'icon' => 'fas fa-history',
                'urutan' => 39,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0040',
                'nama_menu' => 'Export History Stok',
                'route_name' => 'history.export-excel',
                'icon' => 'fas fa-file-excel',
                'urutan' => 40,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | STOCK OPNAME
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0041',
                'nama_menu' => 'Stock Opname',
                'route_name' => 'stock-opname.create',
                'icon' => 'fas fa-clipboard-check',
                'urutan' => 41,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0042',
                'nama_menu' => 'Simpan Stock Opname',
                'route_name' => 'stock-opname.store',
                'icon' => 'fas fa-clipboard-check',
                'urutan' => 42,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0043',
                'nama_menu' => 'Mode Stock Opname ON',
                'route_name' => 'stock-opname.mode-on',
                'icon' => 'fas fa-clipboard-check',
                'urutan' => 43,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0044',
                'nama_menu' => 'Mode Stock Opname OFF',
                'route_name' => 'stock-opname.mode-off',
                'icon' => 'fas fa-clipboard-check',
                'urutan' => 44,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | AKUN USER
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0045',
                'nama_menu' => 'List Akun',
                'route_name' => 'user.index',
                'icon' => 'fas fa-user-cog',
                'urutan' => 45,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0046',
                'nama_menu' => 'Tambah Akun',
                'route_name' => 'user.create',
                'icon' => 'fas fa-user-cog',
                'urutan' => 46,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0047',
                'nama_menu' => 'Simpan Akun',
                'route_name' => 'user.store',
                'icon' => 'fas fa-user-cog',
                'urutan' => 47,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0048',
                'nama_menu' => 'Edit Akun',
                'route_name' => 'user.edit',
                'icon' => 'fas fa-user-cog',
                'urutan' => 48,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0049',
                'nama_menu' => 'Update Akun',
                'route_name' => 'user.update',
                'icon' => 'fas fa-user-cog',
                'urutan' => 49,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0050',
                'nama_menu' => 'Hapus Akun',
                'route_name' => 'user.destroy',
                'icon' => 'fas fa-user-cog',
                'urutan' => 50,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | ROLE
            |--------------------------------------------------------------------------
            */
            [
                'id_menu' => 'MN0051',
                'nama_menu' => 'List Role',
                'route_name' => 'role.index',
                'icon' => 'fas fa-user-shield',
                'urutan' => 51,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0052',
                'nama_menu' => 'Tambah Role',
                'route_name' => 'role.create',
                'icon' => 'fas fa-user-shield',
                'urutan' => 52,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0053',
                'nama_menu' => 'Simpan Role',
                'route_name' => 'role.store',
                'icon' => 'fas fa-user-shield',
                'urutan' => 53,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0054',
                'nama_menu' => 'Edit Role',
                'route_name' => 'role.edit',
                'icon' => 'fas fa-user-shield',
                'urutan' => 54,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0055',
                'nama_menu' => 'Update Role',
                'route_name' => 'role.update',
                'icon' => 'fas fa-user-shield',
                'urutan' => 55,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0056',
                'nama_menu' => 'Hapus Role',
                'route_name' => 'role.destroy',
                'icon' => 'fas fa-user-shield',
                'urutan' => 56,
                'created_at' => Carbon::now(),
            ],
            [
                'id_menu' => 'MN0057',
                'nama_menu' => 'Export Excel Stock Opname',
                'route_name' => 'stock-opname.export-excel',
                'icon' => 'fas fa-file-excel',
                'urutan' => 57,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
