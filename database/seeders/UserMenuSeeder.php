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
            | AKSES KHUSUS USER
            |--------------------------------------------------------------------------
            | USR004 = gudang1@gmail.com
            | Role gudang default tidak bisa dashboard.
            | Tapi user gudang 1 diberi akses khusus ke dashboard.
            |--------------------------------------------------------------------------
            */
            [
                'id_user_menu' => 'UM0001',
                'id_user' => 'USR004',
                'id_menu' => 'MN0001',
                'can_access' => true,
                'created_at' => Carbon::now(),
            ],

        ]);
    }
}
