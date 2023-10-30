<?php

namespace App\Exports;

use App\Models\Inventory;
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


class inventoryExport implements FromQuery, ShouldAutoSize, WithHeadings, WithStyles, WithCustomStartCell, WithTitle
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
        return 'A3';
    }
    public function query()
    {

        $query = Inventory::query()
        ->join('products', 'inventories.product_id', '=', 'products.id')
        ->where('inventories.organization_id', $this->data[0])
        ->where('inventories.type', 'MP')
        ->select(
            'products.name as product_name',
            'inventories.type',
            'inventories.stock',
            'inventories.stock_min',
            'inventories.unit_of_measurement',
            'inventories.location',
            'inventories.lot_number',
            'inventories.note',
            'inventories.status',
            'inventories.total_value'
        );

    if ($this->productName) {
        $query->where('products.name', $this->productName);
    }

     return $query;
    }
    

    public function headings(): array
    {
        return [
            'Producto',
            'Tipo',
            'Stock',
            'Stock Mínimo',
            'Unidad de Medida',
            'Ubicación',
            'Número de Lote',
            'Nota',
            'Estado',
            'Valor Total',
        ];
    }
    public function title(): string
    {
        return 'Inventario MP'; // Asigna un nombre diferente para esta hoja
    }
    
   
    public function styles(Worksheet $sheet)

    {
        $sheet->setCellValue('D1', $this->data[1]);
        $sheet->setCellValue('D2', 'Reporte de Inventario de Materia Prima');

        // Aplicar alineación centrada a las columnas A a G
    $sheet->getStyle('A:G')->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
    ]);

    // Obtén la dimensión de la columna H y establece la alineación a la izquierda
    $sheet->getStyle('H')->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_LEFT,
        ],
    ]);
    // Aplicar alineación centrada a las columnas I a la última columna
    $highestColumn = $sheet->getHighestColumn();
    $sheet->getStyle('I:' . $highestColumn)->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
    ]);



        // Obtener el número de la última fila con contenido
        $highestRow = $sheet->getHighestRow();

        // Obtener el índice de la última columna con contenido
        $highestColumnIndex = $sheet->getHighestDataColumn();

        $sheet->mergeCells('A1:C2');

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
        $sheet->getStyle('1:3')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Aplicar estilo a la fila 1 (tamaño de fuente 24)
        $sheet->getStyle('1')->getFont()->setSize(22);

        // Aplicar estilo a la fila 2 (tamaño de fuente 20)
        $sheet->getStyle('2')->getFont()->setSize(18);


        // Ajusta el ancho de la columna H basado en su contenido
        $columnIndex = 'H'; // Columna que deseas ajustar
        $sheet->getColumnDimension($columnIndex)->setAutoSize(true);
       
       
    }
    /*
    public function drawings()
    {
        // Ruta de la imagen redimensionada
        $imagePath = public_path('code.png');

        // Crea un objeto Drawing
        $drawing = new Drawing();
        $drawing->setName('MyImage');
        $drawing->setDescription('Description');
        $drawing->setPath($imagePath);

        // Establece el tamaño de la imagen para que se ajuste al rango de celdas A1:C3
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(0); // Ajusta la posición horizontal
        $drawing->setOffsetY(0); // Ajusta la posición vertical
        $drawing->setWidthAndHeight(200, 200); // Ajusta el ancho y la altura para que coincida con A1:C3

        return [$drawing];
    }*/
   
}
