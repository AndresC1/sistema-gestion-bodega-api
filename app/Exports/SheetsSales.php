<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetsSales implements WithMultipleSheets
{
    
    use Exportable;

    protected $year;
    protected $id_organizacion;


    public function __construct(int $id_organizacion, int $year)
    {
        $this->year = $year;
        $this->id_organizacion = $id_organizacion;
    }
    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new SalesExport($this->year, $month, $this->id_organizacion);
        }

        return $sheets;
    }
}
