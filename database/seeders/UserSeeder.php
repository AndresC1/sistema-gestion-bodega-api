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
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => config('app_settings.TEST_NAME'),
            'username' => config('app_settings.TEST_USERNAME'),
            'email' => config('app_settings.TEST_EMAIL'),
            'password' => Hash::make(config('app_settings.TEST_PASSWORD')),
            'role_id' => config('app_settings.TEST_ROLE_ID'),
            'organization_id' => null,
            'last_login_at' => now(),
            'status' => 'active',
        ]);
        // if(!DB::table('users')->where('username', config('app_settings.TEST_USERNAME'))->first()){
        // }
        DB::table('users')->insert([
            'name' => config('app_settings.TEST_NAME_ADMIN'),
            'username' => config('app_settings.TEST_USERNAME_ADMIN'),
            'email' => config('app_settings.TEST_EMAIL_ADMIN'),
            'password' => Hash::make(config('app_settings.TEST_PASSWORD_ADMIN')),
            'role_id' => config('app_settings.TEST_ROLE_ID_ADMIN'),
            'organization_id' => 3,
            'last_login_at' => now(),
            'status' => 'active',
        ]);
        // if(!DB::table('users')->where('username', config('app_settings.TEST_USERNAME_ADMIN'))->first()){
        // }
        DB::table('users')->insert([
            'name' => config('app_settings.TEST_NAME_GUEST'),
            'username' => config('app_settings.TEST_USERNAME_GUEST'),
            'email' => config('app_settings.TEST_EMAIL_GUEST'),
            'password' => Hash::make(config('app_settings.TEST_PASSWORD_GUEST')),
            'role_id' => config('app_settings.TEST_ROLE_ID_GUEST'),
            'organization_id' => 3,
            'last_login_at' => now(),
            'status' => 'active',
        ]);
        // if(!DB::table('users')->where('username', config('app_settings.TEST_USERNAME_GUEST'))->first()){
        // }
        UserFactory::new()->count(500)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
