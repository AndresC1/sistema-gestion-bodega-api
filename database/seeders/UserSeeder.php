<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
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
        if(!DB::table('users')->where('username', getenv('TEST_USERNAME'))->first()){
            DB::table('users')->insert([
                'name' => getenv('TEST_NAME'),
                'username' => getenv('TEST_USERNAME'),
                'email' => getenv('TEST_EMAIL'),
                'password' => Hash::make(getenv('TEST_PASSWORD')),
                'role_id' => getenv('TEST_ROLE_ID'),
                'organization_id' => null,
                'last_login_at' => now(),
                'status' => 'active',
            ]);
        }
        UserFactory::new()->count(500)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
