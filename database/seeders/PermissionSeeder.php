<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_permission = [
            ["name" => "view_list_organization", "description" => "Ver lista de las organizaciones del sistema"],
            ["name" => "add_organization", "description" =>"Creacion de nueva organizacion en el sistema"],
            ["name" => "update_data_organization", "description" =>"Actualizacion de los datos de las organizaciones"],
            ["name" => "delete_organization", "description" =>"Eliminacion de organizaciones"],
            ["name" => "view_organization", "description" =>"Ver datos de una organizacion"],
            ["name" => "list_user_by_organization", "description" =>"Lista de usuarios que pertenecen a una organizacion"],
            ["name" => "view_list_sector", "description" =>"Ver lista de sectores"],
            ["name" => "view_list_organization_by_sector", "description" =>"Ver lista de organizaciones por sector"],
            ["name" => "add_user", "description" =>"Creacion de nuevos usuarios al sistema"],
            ["name" => "change_status_by_user", "description" =>"Cambio de estado por usuarios"],
            ["name" => "view_list_user", "description" =>"Ver lista de usuarios del sistema"],
            ["name" => "view_list_roles", "description" =>"Ver lista de roles"],
            ["name" => "change_role_by_user", "description" =>"Cambio de rol a usuario"],
            ["name" => "see_my_organization", "description" =>"Ver informacion de la organizacion a la que pertece el usuario"],
            ["name" => "list_user_my_organization", "description" =>"Lista de usuarios de la organizacion a la que pertene el usuario"],
            ["name" => "update_my_organization", "description" =>"Actualizar datos de mmi organizacion"],
            ["name" => "view_list_cities_and_municipalities", "description" =>"Ver la lista de ciudades y municipios"],
            ["name" => "list_providers_my_organization", "description" =>"Ver lista de proveedores de la organizacion"],
            ["name" => "view_list_providers_by_organization", "description" =>"Listado de proveedores por organizacion"],
            ["name" => "add_providers", "description" =>"Creacion de nuevos proveedores"],
            ["name" => "update_providers", "description" =>"Actualizacion de datos de proveedores"],
            ["name" => "change_status_provider", "description" =>"Cambio de estado por proveedor"],
            ["name" => "see_my_providers", "description" =>"Ver informacion de proveedores de mi organizacion"],
             ["name" => "list_clients_my_organization", "description" =>"Ver listado de clientes de mi organizacion"],
            // ["name" => "", "description" =>""],
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('permissions')->insert($list_permission);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
