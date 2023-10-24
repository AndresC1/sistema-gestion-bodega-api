<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
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
        return 'A4';
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
            Sale::raw("DATE_FORMAT(sales.date, '%d/%m/%Y') as Fecha"),
            'sales.total as Total',
            'details_sales.cost_total',
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
            'Precio Venta',
            'Costo',
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
        $fecha1 = Carbon::createFromFormat('Y-m-d', $this->data[2])->format('d/m/Y');
        $fecha2 = Carbon::createFromFormat('Y-m-d', $this->data[3])->format('d/m/Y');
        $sheet->setCellValue('D1', $this->data[1]);
        $sheet->setCellValue('D2', 'Reporte de Venta');
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
