<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class sheetscomplete implements WithMultipleSheets
{ use Exportable;


    private $FI;
    private $FF;
    public function __construct(String $FI, String $FF)
    {
        $this->FI = $FI;
        $this->FF = $FF;
    }
    public function sheets(): array
    {
        $organization_id = Auth::user()->organization_id;
        $organization_name = Auth::user()->organization->name;
        $sheets = [];
        $data = [$organization_id, $organization_name, $this->FI, $this->FF];

        $sheets['Sheet1'] = new inventoryExport($data);
        $sheets['Sheet2'] = new inventoryExportPT($data);
        $sheets['Sheet3'] = new SalesExport($data);
        $sheets['Sheet4'] = new PurchaseExport($data);

        return $sheets;
    }
}
