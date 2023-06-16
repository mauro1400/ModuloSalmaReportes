<?php

namespace App\Exports;

use App\Models\ConsultaReporteArticulos;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ConsultaArticulosExport implements FromView, ShouldAutoSize, WithStyles, WithDrawings, WithColumnWidths
{
    use Exportable;


    private $palabraclave;
    private $fechainicio;
    private $fechafin;
    private $regional;
    private $material;
    private $solicitante;
    private $totalRegistros;


    public function __construct($palabraclave, $fechainicio, $fechafin, $regional, $material, $solicitante)
    {
        $this->$palabraclave = $palabraclave;
        $this->$fechainicio = $fechainicio;
        $this->$fechafin = $fechafin;
        $this->$regional = $regional;
        $this->$material = $material;
        $this->$solicitante = $solicitante;
        $this->totalRegistros = $this->getTotalRegistros();

    }
    public function view(): View
    {
        $busqueda = ConsultaReporteArticulos::consultaArticulos(
            $this->palabraclave,
            $this->fechainicio,
            $this->fechafin,
            $this->regional,
            $this->material,
            $this->solicitante
        );

        return view('exports.Excel.ConsultaReporteArticulos', ['busqueda' => $busqueda]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 3,
            'B' => 20,
            'C' => 9,
            'D' => 30,
            'E' => 25,
            'F' => 30,
            'G' => 30,
            'H' => 12,
            'I' => 10,
            'J' => 15,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $totalRegistros = $this->totalRegistros;

        $sheet->getRowDimension('2')->setRowHeight(30);

        $sheet->mergeCells('A2:L2');
        $sheet->getCell('A2')->getStyle()->getFont()->setSize(15);
        $sheet->getCell('A2')->getStyle()->getFont()->setBold(true);

        $sheet->getStyle('A2:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:L2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A4:L4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:L4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A4:L4')->getAlignment()->setWrapText(true);

        $sheet->setCellValue('A2', 'REPORTE DE ARTICULOS');

        $dataRange = 'A5:L' . ($totalRegistros + 4);
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A')->getAlignment()->setWrapText(true);
        $sheet->getStyle('B')->getAlignment()->setWrapText(true);

        $sheet->getStyle('A4:L4')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'C6E2FF'],
            ],
        ]);

        return [
            $dataRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function drawings()
    {
        $imagePath =  public_path('/assets/img/logo-snv.png');
        $drawing = new Drawing();
        $drawing->setPath($imagePath);
        $drawing->setCoordinates('A1');
        $drawing->setHeight(80);

        return $drawing;
    }
    private function getTotalRegistros()
    {
        return ConsultaReporteArticulos::consultaArticulos(
            $this->fechainicio,
            $this->palabraclave,
            $this->fechafin,
            $this->regional,
            $this->material,
            $this->solicitante
        )->count();
    }
}
