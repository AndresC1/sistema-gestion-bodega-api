<?php

namespace App\Models\ExportSQL;

class TableToExportForOrganizations
{
    public static function getTablesToExport()
    {
        return [
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
