<?php

namespace App\Exports;

use App\Models\DetailsSale;
use App\Models\OutputsProduct;
use App\Models\Sale;
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
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\DB;

class LowExport implements FromQuery, ShouldAutoSize, WithHeadings, WithStyles, WithCustomStartCell, WithTitle
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function startCell(): string
    {
        return 'A4';
    }
    public function query()
    {
        $limit = 5; // Límite mínimo absoluto
        $percentage = 30; // Porcentaje de productos menos vendidos a mostrar

        return OutputsProduct::query()
            ->select(
                'products.name',
                DB::raw('SUM(outputs_products.quantity) as total_quantity'),
                DB::raw('SUM(outputs_products.total) as total_earnings')
            )
            ->join('inventories', 'outputs_products.inventory_id', '=', 'inventories.id')
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->where('inventories.type', 'PT')
            ->whereBetween('outputs_products.date', [$this->data[2], $this->data[3]])
            ->groupBy('products.name')
            ->orderBy('total_quantity')
            ->limit($limit + ceil($limit * ($percentage / 100))); // Limitar la cantidad de resultados según la lógica establecida
    }
    

    public function headings(): array
    {
        return [
            'Nombre del Producto',
            'Cantidad Total Vendida',
            'Ganancia Total',
        ];
    }
    public function title(): string
    {
        return 'Menos vendido'; // Asigna un nombre diferente para esta hoja
    }
    
   
    public function styles(Worksheet $sheet)

    {
        $fecha1 = Carbon::createFromFormat('Y-m-d', $this->data[2])->format('d/m/Y');
        $fecha2 = Carbon::createFromFormat('Y-m-d', $this->data[3])->format('d/m/Y');
        $sheet->setCellValue('A1', $this->data[1]);
        $sheet->setCellValue('A2', 'Reporte Producto Menos Vendido');
        $sheet->setCellValue('A3', 'De ' . $fecha1 . ' A ' . $fecha2);

         // Aplicar alineación derecha a todas las columnas, excepto la columna A y la columna I=> era la de las notas
        $sheet->getStyle('A:I')->applyFromArray([
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

         // Combinar celdas de la fila 3 desde A3 hasta la última columna con contenido
         $tableStartCell = 'A3';
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
