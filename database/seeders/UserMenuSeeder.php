<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserMenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_user_menu')->insert([

            /*
            |--------------------------------------------------------------------------
            | GUDANG 1 - AKSES KHUSUS DASHBOARD
            |--------------------------------------------------------------------------
            | Gudang default tidak punya dashboard.
            | USR004 diberi akses dashboard.
            |--------------------------------------------------------------------------
            */
            [
                'id_user_menu' => 'UM0001',
                'id_user' => 'USR004',
                'id_menu' => 'MN0001',
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | OWNER 2 - AKSES KHUSUS KELOLA BARANG
            |--------------------------------------------------------------------------
            | Owner default hanya dashboard + laporan.
            | USR006 diberi akses tambahan untuk barang.
            |--------------------------------------------------------------------------
            */
            [
                'id_user_menu' => 'UM0002',
                'id_user' => 'USR006',
                'id_menu' => 'MN0002', // barang.index
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'id_user_menu' => 'UM0003',
                'id_user' => 'USR006',
                'id_menu' => 'MN0003', // barang.create
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'id_user_menu' => 'UM0004',
                'id_user' => 'USR006',
                'id_menu' => 'MN0004', // barang.store
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'id_user_menu' => 'UM0005',
                'id_user' => 'USR006',
                'id_menu' => 'MN0005', // barang.edit
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'id_user_menu' => 'UM0006',
                'id_user' => 'USR006',
                'id_menu' => 'MN0006', // barang.update
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'id_user_menu' => 'UM0007',
                'id_user' => 'USR006',
                'id_menu' => 'MN0007', // barang.destroy
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
