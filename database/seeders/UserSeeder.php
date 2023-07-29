<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if(!DB::table('users')->where('username', 'SGB_Admin')->first()){
            DB::table('users')->insert([
                'name' => 'Super Admin',
                'username' => 'SGB_Admin',
                'email' => null,
                'password' => Hash::make('SistemaBodega2023'),
                'role_id' => 1,
                'organization_id' => null,
                'last_login_at' => now(),
                'status' => 'active',
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
