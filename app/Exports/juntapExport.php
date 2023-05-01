<?php

namespace App\Exports;

use App\Models\Nomina;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class juntapExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $empleados;
    protected $titulo;
/*
    public function __construct(Collection $empleados, $titulo)
    {
        $this->empleados = $empleados;
        $this->titulo = $titulo;
    }*/

    public $data;
    public function __construct(Collection $empleados, $titulo)
{
    $this->empleados = $empleados;
    $this->titulo = $titulo;
   
}

    public function collection()
    {
        $collection = $this->empleados;
        $collection->prepend($this->headings()); // Agregar esta línea
        return $collection;
    
    }

    public function headings(): array
    {
        return [
            'CódigoE',
            'Grado',
            'Cédula',
            'Nombre',
            'Apellido',
            
            'Grado a Ascender',
        ];
    }

    /*
    public function title(): string
{
    $titulo = implode(' ', $this->titulo);
    return $titulo;
}*/
public function title(): string
{
    return 'Reporte';
}
public function styles(Worksheet $sheet)
{
    $sheet->setCellValue('A1', $this->titulo);
    $sheet->mergeCells('A1:G1');
   // $sheet->getColumnDimension('A')->setWidth(45);
   // $sheet->getDefaultColumnDimension()->setWidth(25);
   //$sheet->getRowDimension(1)->setRowHeight(30);
   //$sheet->getColumnDimension('A')->setAutoSize(true);
   $sheet->getRowDimension(1)->setRowHeight(45);
  // $sheet->autoSize();
    return [
        1 => [
            'font' => [
                'bold' => true,
                'size' => 20,
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ],
        2 => [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'D9D9D9',
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => [
                        'rgb' => '000000',
                    ],
                ],
            ],
        ],
    ];
}
}