<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleMenuSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA MENU BERDASARKAN ROUTE NAME
        |--------------------------------------------------------------------------
        | Key   = route_name
        | Value = id_menu
        |--------------------------------------------------------------------------
        */
        $menuMap = DB::table('tbl_menu')
            ->pluck('id_menu', 'route_name');

        $data = [];

        $nomor = 1;


        /*
        |--------------------------------------------------------------------------
        | FUNCTION TAMBAH AKSES ROLE
        |--------------------------------------------------------------------------
        */
        $tambahAkses = function ($idRole, $routeNames) use (&$data, &$nomor, $menuMap, $now) {

            foreach ($routeNames as $routeName) {

                /*
                |--------------------------------------------------------------------------
                | SKIP JIKA ROUTE BELUM ADA DI TBL_MENU
                |--------------------------------------------------------------------------
                | Supaya seeder tidak error foreign key.
                |--------------------------------------------------------------------------
                */
                if (!isset($menuMap[$routeName])) {
                    continue;
                }

                $data[] = [
                    'id_role_menu' => 'RM' . sprintf('%04s', $nomor),
                    'id_role' => $idRole,
                    'id_menu' => $menuMap[$routeName],
                    'can_access' => true,
                    'created_at' => $now,
                ];

                $nomor++;
            }
        };


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        | Admin bisa semua akses tanpa terkecuali.
        |--------------------------------------------------------------------------
        */
        foreach ($menuMap as $routeName => $idMenu) {

            $data[] = [
                'id_role_menu' => 'RM' . sprintf('%04s', $nomor),
                'id_role' => 'RL0001',
                'id_menu' => $idMenu,
                'can_access' => true,
                'created_at' => $now,
            ];

            $nomor++;
        }


        /*
        |--------------------------------------------------------------------------
        | KASIR
        |--------------------------------------------------------------------------
        | Kasir hanya transaksi dan pelanggan.
        |--------------------------------------------------------------------------
        */
        $tambahAkses('RL0002', [

            /*
            |----------------------------------------------------------------------
            | PELANGGAN
            |----------------------------------------------------------------------
            */
            'pelanggan.index',
            'pelanggan.create',
            'pelanggan.store',
            'pelanggan.edit',
            'pelanggan.update',
            'pelanggan.destroy',

            /*
            |----------------------------------------------------------------------
            | TRANSAKSI
            |----------------------------------------------------------------------
            */
            'transaksi.index',
            'transaksi.create',
            'transaksi.store',
            'transaksi.cetak',
        ]);


        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        | Owner hanya dashboard dan laporan.
        |--------------------------------------------------------------------------
        */
        $tambahAkses('RL0003', [

            /*
            |----------------------------------------------------------------------
            | DASHBOARD
            |----------------------------------------------------------------------
            */
            'dashboard.index',
            'dashboard.grafik',

            /*
            |----------------------------------------------------------------------
            | LAPORAN
            |----------------------------------------------------------------------
            */
            'laporan.index',
            'laporan.pdf',
            'laporan.excel',
        ]);


        /*
        |--------------------------------------------------------------------------
        | GUDANG
        |--------------------------------------------------------------------------
        | Gudang hampir semua, kecuali:
        | - Dashboard
        | - Pelanggan
        | - Transaksi
        | - Laporan
        | - Akun/User
        |--------------------------------------------------------------------------
        */
        $tambahAkses('RL0004', [

            /*
            |----------------------------------------------------------------------
            | BARANG
            |----------------------------------------------------------------------
            */
            'barang.index',
            'barang.create',
            'barang.store',
            'barang.edit',
            'barang.update',
            'barang.destroy',

            /*
            |----------------------------------------------------------------------
            | KATEGORI
            |----------------------------------------------------------------------
            */
            'kategori.index',
            'kategori.create',
            'kategori.store',
            'kategori.edit',
            'kategori.update',
            'kategori.destroy',

            /*
            |----------------------------------------------------------------------
            | PURCHASE ORDER
            |----------------------------------------------------------------------
            */
            'po.index',
            'po.create',
            'po.store',
            'po.edit',
            'po.update',
            'po.destroy',

            /*
            |----------------------------------------------------------------------
            | BARANG MASUK
            |----------------------------------------------------------------------
            */
            'barang-masuk.index',
            'barang-masuk.create',
            'barang-masuk.store',
            'barang-masuk.edit',
            'barang-masuk.update',
            'barang-masuk.destroy',

            /*
            |----------------------------------------------------------------------
            | HISTORY STOK
            |----------------------------------------------------------------------
            */
            'history.index',
            'history.export-excel',

            /*
            |----------------------------------------------------------------------
            | STOCK OPNAME
            |----------------------------------------------------------------------
            */
            'stock-opname.create',
            'stock-opname.store',
            'stock-opname.excel',
            'stock-opname.mode-on',
            'stock-opname.mode-off',
        ]);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_role_menu')->insert($data);
    }
}
