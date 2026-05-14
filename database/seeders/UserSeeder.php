<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_user')->insert([
            [
                'id_user' => 'USR001',
                'id_role' => 'RL0001',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'created_at' => Carbon::now(),
            ],
            [
                'id_user' => 'USR002',
                'id_role' => 'RL0002',
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('123'),
                'created_at' => Carbon::now(),
            ],
            [
                'id_user' => 'USR003',
                'id_role' => 'RL0004',
                'email' => 'gudang@gmail.com',
                'password' => Hash::make('123'),
                'created_at' => Carbon::now(),
            ],
                [
                    'id_user' => 'USR004',
                    'id_role' => 'RL0003',
                    'email' => 'owner@gmail.com',
                    'password' => Hash::make('123'),
                    'created_at' => Carbon::now(),
                ]
        ]);
    }
}
