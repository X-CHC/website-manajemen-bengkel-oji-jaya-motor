<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleMenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_role_menu')->insert([

            /*
            |--------------------------------------------------------------------------
            | ADMIN - SEMUA MENU
            |--------------------------------------------------------------------------
            */
            ['id_role_menu' => 'RM0001', 'id_role' => 'RL0001', 'id_menu' => 'MN0001', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0002', 'id_role' => 'RL0001', 'id_menu' => 'MN0002', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0003', 'id_role' => 'RL0001', 'id_menu' => 'MN0003', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0004', 'id_role' => 'RL0001', 'id_menu' => 'MN0004', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0005', 'id_role' => 'RL0001', 'id_menu' => 'MN0005', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0006', 'id_role' => 'RL0001', 'id_menu' => 'MN0006', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0007', 'id_role' => 'RL0001', 'id_menu' => 'MN0007', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0008', 'id_role' => 'RL0001', 'id_menu' => 'MN0008', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0009', 'id_role' => 'RL0001', 'id_menu' => 'MN0009', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0010', 'id_role' => 'RL0001', 'id_menu' => 'MN0010', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0011', 'id_role' => 'RL0001', 'id_menu' => 'MN0011', 'can_access' => true, 'created_at' => Carbon::now()],


            /*
            |--------------------------------------------------------------------------
            | KASIR - DEFAULT
            |--------------------------------------------------------------------------
            */
            ['id_role_menu' => 'RM0012', 'id_role' => 'RL0002', 'id_menu' => 'MN0001', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0013', 'id_role' => 'RL0002', 'id_menu' => 'MN0004', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0014', 'id_role' => 'RL0002', 'id_menu' => 'MN0005', 'can_access' => true, 'created_at' => Carbon::now()],


            /*
            |--------------------------------------------------------------------------
            | OWNER - DEFAULT
            |--------------------------------------------------------------------------
            */
            ['id_role_menu' => 'RM0015', 'id_role' => 'RL0003', 'id_menu' => 'MN0001', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0016', 'id_role' => 'RL0003', 'id_menu' => 'MN0010', 'can_access' => true, 'created_at' => Carbon::now()],


            /*
            |--------------------------------------------------------------------------
            | GUDANG - DEFAULT
            |--------------------------------------------------------------------------
            | Sengaja tidak diberi Dashboard.
            | Jadi gudang default tidak bisa akses dashboard.
            |--------------------------------------------------------------------------
            */
            ['id_role_menu' => 'RM0017', 'id_role' => 'RL0004', 'id_menu' => 'MN0002', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0018', 'id_role' => 'RL0004', 'id_menu' => 'MN0003', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0019', 'id_role' => 'RL0004', 'id_menu' => 'MN0006', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0020', 'id_role' => 'RL0004', 'id_menu' => 'MN0007', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0021', 'id_role' => 'RL0004', 'id_menu' => 'MN0008', 'can_access' => true, 'created_at' => Carbon::now()],
            ['id_role_menu' => 'RM0022', 'id_role' => 'RL0004', 'id_menu' => 'MN0009', 'can_access' => true, 'created_at' => Carbon::now()],
        ]);
    }
}
