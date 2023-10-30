<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class sheetscomplete implements WithMultipleSheets
{ use Exportable;


    private $FI;
    private $FF;
    private $type;
    private $product;
    public function __construct(String $FI, String $FF, String $type, String $product=null)
    {
        $this->FI = $FI;
        $this->FF = $FF;
        $this->type = $type;
        $this->product = $product;
    }
    public function sheets(): array
    {
        $organization_id = Auth::user()->organization_id;
        $organization_name = Auth::user()->organization->name;
        $sheets = [];
        if($this->product)  $data = [$organization_id, $organization_name, $this->FI, $this->FF, $this->product];
        else    $data = [$organization_id, $organization_name, $this->FI, $this->FF];
        
        //Inventario de Materia Prima
        if ($this->type == 1)   $sheets['Sheet1'] = new inventoryExport($data);
        //Inventario de Producto Terminado
        if ($this->type == 2)   $sheets['Sheet2'] = new inventoryExportPT($data);
        //Productos mas vendidos
        if ($this->type == 3)   $sheets['Sheet3'] = new BestSeller($data);
        //productos Menos Vendidos
        if ($this->type == 4)   $sheets['Sheet3'] = new LowExport($data);
        //Reporte de ventas
        if ($this->type == 5)   $sheets['Sheet4'] = new SalesExport($data);

        //Reporte de Compras
        if ($this->type == 6)   $sheets['Sheet5'] = new PurchaseExport($data);

        return $sheets;
    }
}
