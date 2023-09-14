<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiplesSheet implements WithMultipleSheets
{

    use Exportable;

    protected $year;
    protected $id_organizacion;
    protected $tipo;

    public function __construct(int $id_organizacion, int $year, String $tipo)
    {
        $this->year = $year;
        $this->id_organizacion = $id_organizacion;
        $this->tipo = $tipo;
    }
    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new inventoryExport($this->year, $month, $this->id_organizacion, $this->tipo);
        }

        return $sheets;
    }
   
}
