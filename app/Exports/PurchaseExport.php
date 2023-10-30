<?php

namespace App\Exports;

use App\Models\DetailsPurchase;
use App\Models\Purchase;
use Carbon\Carbon;
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
    private $productName;

    public function __construct($data)
    {
        $this->data = $data;
        $this->productName = $data[4] ?? null;
    }
    public function startCell(): string
    {
        return 'A4';
    }

    public function query()
    {

        //nota de entrada materia prima
        $query= Purchase::query()
        ->join('details_purchases', 'purchases.id', '=', 'details_purchases.purchase_id')
        ->join('products', 'details_purchases.product_id', '=', 'products.id')
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('organizations', 'purchases.organization_id', '=', 'organizations.id')
        ->join('providers', 'purchases.provider_id', '=', 'providers.id')
        ->where('purchases.organization_id', $this->data[0])
        ->whereBetween('purchases.date', [$this->data[2], $this->data[3]])
        ->select(
            'purchases.number_bill',
            'products.name as nombre_producto',
            'providers.name as nombre_proveedor',
            'users.name as nombre_usuario',
            'purchases.date',
            'details_purchases.price',
            'details_purchases.quantity',
            'details_purchases.total',
        );

        if ($this->productName) {
            $query->where('products.name', $this->productName);
        }
    
        return $query;
    }

    public function headings(): array
    {
        return [
            'factura',
            'producto',
            'proveedor',
            'nombre usuario',
            'fecha',
            'precio',
            'cantidad',
            'total',
           
        ];
    }
    public function title(): string
    {
        return 'Compras'; // Asigna un nombre diferente para esta hoja
    }
    public function styles(Worksheet $sheet)
    {
        $fecha1 = Carbon::createFromFormat('Y-m-d', $this->data[2])->format('d/m/Y');
        $fecha2 = Carbon::createFromFormat('Y-m-d', $this->data[3])->format('d/m/Y');

        $title = ($this->productName) ? 'Compras de ' . $this->productName : 'Reporte de Compra';

        $sheet->setCellValue('D1', $this->data[1]);
        $sheet->setCellValue('D2', $title);
        $sheet->setCellValue('D3', 'De ' . $fecha1 . ' A ' . $fecha2);

        $sheet->getStyle('A:I')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);


       // Obtener el número de la última fila con contenido
       $highestRow = $sheet->getHighestRow();

       // Obtener el índice de la última columna con contenido
       $highestColumnIndex = $sheet->getHighestDataColumn();

       $sheet->mergeCells('A1:C3');

       // Determinar el rango de la tabla basado en el contenido
       $tableStartColumn = 'A'; // Columna inicial de la tabla
       $tableEndColumn = $highestColumnIndex; // Columna final de la tabla
       $tableStartRow = 1; // Fila inicial de la tabla
       $tableEndRow = $highestRow; // Fila final de la tabla

       // Combinar celdas de la fila 1 desde A1 hasta la última columna con contenido
       $tableStartCell = 'D1';
       $tableEndCell = $tableEndColumn . '1';
       $sheet->mergeCells($tableStartCell . ':' . $tableEndCell);

       // Combinar celdas de la fila 2 desde A2 hasta la última columna con contenido
       $tableStartCell = 'D2';
       $tableEndCell = $tableEndColumn . '2';
       $sheet->mergeCells($tableStartCell . ':' . $tableEndCell);

        // Combinar celdas de la fila 3 desde A3 hasta la última columna con contenido
        $tableStartCell = 'D3';
        $tableEndCell = $tableEndColumn . '3';
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
       $sheet->getStyle('A1:' . $tableEndColumn . '3')->applyFromArray([
           'alignment' => [
               'horizontal' => Alignment::HORIZONTAL_CENTER,
               'vertical' => Alignment::VERTICAL_CENTER,
           ],
       ]);
       $sheet->getStyle('1:4')->applyFromArray([
           'font' => [
               'bold' => true,
           ],
       ]);

       // Aplicar estilo a la fila 1 (tamaño de fuente 24)
       $sheet->getStyle('1')->getFont()->setSize(22);

       // Aplicar estilo a la fila 2 (tamaño de fuente 20)
       $sheet->getStyle('2')->getFont()->setSize(18);

       // Aplicar estilo a la fila 3 (tamaño de fuente 16)
       $sheet->getStyle('3')->getFont()->setSize(14);
    }
}
