<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            [
                'name' => 'super_admin',
                'description' => 'Rol con el máximo nivel de permisos con el poder de realizar cualquier acción en el sistema',
            ],
            [
                'name' => 'admin',
                'description' => 'Rol con permisos de administrador para una organización',
            ],
            [
                'name' => 'guest',
                'description' => 'Rol con muchas restricciones',
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
