<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpParser\Node\Stmt\Return_;

class SalesExport implements FromQuery, ShouldAutoSize, WithHeadings, WithStyles, WithCustomStartCell, WithTitle
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
        // salida de producto terminado que ponga la nota
        return Sale::query()
        ->join('clients', 'sales.client_id', '=', 'clients.id')
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->join('organizations', 'sales.organization_id', '=', 'organizations.id')
        ->join('details_sales', 'sales.id', '=', 'details_sales.sale_id')
        ->where('sales.organization_id', $this->data[0])
        ->whereBetween('sales.created_at', [$this->data[2], $this->data[3]])
        ->select(
            'sales.number_bill as Número de Factura',
            'clients.name as Cliente',
            'users.name as Usuario',
            'sales.date as Fecha',
            'sales.total as Total',
            'sales.earning_total as Ganancia Total',
            'sales.note as Nota'
        );
    }
    public function headings(): array
    {
        return [
            'factura',
            'Nombre Cliente',
            'Usuario',
            'fecha',
            'total',
            'Ganancia Total',
            'Nota',
           
        ];
    }
    public function title(): string
    {
        return 'Ventas'; // Asigna un nombre diferente para esta hoja
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', $this->data[1]);
        $sheet->setCellValue('A2', 'Reporte de Venta');

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
