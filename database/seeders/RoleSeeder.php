<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_role')->insert([
            [
                'id_role' => 'RL0001',
                'nama_role' => 'admin',
                'tingkat_role' => '1',
                'created_at' => Carbon::now(),
            ],
            [
                'id_role' => 'RL0002',
                'nama_role' => 'kasir',
                'tingkat_role' => '2',
                'created_at' => Carbon::now(),
            ],
            [
                'id_role' => 'RL0003',
                'nama_role' => 'owner',
                'tingkat_role' => '3',
                'created_at' => Carbon::now(),
            ],
            [
                'id_role' => 'RL0004',
                'nama_role' => 'gudang',
                'tingkat_role' => '3',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
