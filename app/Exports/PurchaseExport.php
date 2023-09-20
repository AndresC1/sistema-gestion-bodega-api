<?php

namespace App\Exports;

use App\Models\DetailsPurchase;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class PurchaseExport implements FromQuery, ShouldAutoSize, WithHeadings, WithStyles, WithCustomStartCell, WithTitle
{

    private $data; 

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function startCell(): string
    {
        return 'A3';
    }

    public function query()
    {

        //nota de entrada materia prima
        return Purchase::query()
        ->join('details_purchases', 'purchases.id', '=', 'details_purchases.purchase_id')
        ->join('products', 'details_purchases.product_id', '=', 'products.id')
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('organizations', 'purchases.organization_id', '=', 'organizations.id')
        ->join('providers', 'purchases.provider_id', '=', 'providers.id')
        ->where('purchases.organization_id', $this->data[0])
        ->whereBetween('purchases.created_at', [$this->data[2], $this->data[3]])
        ->select(
            'purchases.number_bill',
            'products.name as nombre_producto',
            'organizations.name as nombre_organizacion',
            'providers.name as nombre_proveedor',
            'users.name as nombre_usuario',
            'purchases.date',
            'purchases.total',
            'details_purchases.quantity',
            'details_purchases.price',
            
        );
    }

    public function headings(): array
    {
        return [
            'factura',
            'producto',
            'organizacion',
            'proveedor',
            'nombre usuario',
            'fecha',
            'total',
            'cantidad',
            'precio',
           
        ];
    }
    public function title(): string
    {
        return 'Compras'; // Asigna un nombre diferente para esta hoja
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', $this->data[1]);
        $sheet->setCellValue('A2', 'Reporte de Compra');

         // Aplicar alineación derecha a todas las columnas, excepto la columna A y la columna I=> era la de las notas
        $sheet->getStyle('B:H')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);
        $sheet->getStyle('J:ZZ')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            
        ]);


      // Obtener el número de la última fila con contenido
        $highestRow = $sheet->getHighestRow();

        // Obtener el índice de la última columna con contenido
        $highestColumnIndex = $sheet->getHighestDataColumn();

        // Determinar el rango de la tabla basado en el contenido
        $tableStartColumn = 'A'; // Columna inicial de la tabla
        $tableEndColumn = $highestColumnIndex; // Columna final de la tabla
        $tableStartRow = 1; // Fila inicial de la tabla
        $tableEndRow = $highestRow; // Fila final de la tabla

        // Combinar celdas de la fila 1 desde A1 hasta la última columna con contenido
        $tableStartCell = 'A1';
        $tableEndCell = $tableEndColumn . '1';
        $sheet->mergeCells($tableStartCell . ':' . $tableEndCell);

        // Combinar celdas de la fila 2 desde A2 hasta la última columna con contenido
        $tableStartCell = 'A2';
        $tableEndCell = $tableEndColumn . '2';
        $sheet->mergeCells($tableStartCell . ':' . $tableEndCell);

        // Aplicar bordes a toda la tabla
        $tableRange = $tableStartColumn . $tableStartRow . ':' . $tableEndColumn . $tableEndRow;
        $sheet->getStyle($tableRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        // Centrar el contenido de la fila 1 y 2
        $sheet->getStyle('A1:' . $tableEndColumn . '2')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('1:3')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }
}
