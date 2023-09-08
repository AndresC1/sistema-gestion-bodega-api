<?php

namespace App\Models\ExportSQL;

class TableToExportGlobal
{
    public static function getTablesToExport()
    {
        return [
            'roles',
            'permissions',
            'role_permissions',
            'cities',
            'municipalities',
            'sectors',
            'organizations',
            'users',
            'clients',
            'providers',
            'inventories',
            'purchases',
            'details_purchases',
            'product_inputs',
            'details_product_inputs',
            'sales',
            'details_sales',
            'outputs_products',
        ];
    }
}
