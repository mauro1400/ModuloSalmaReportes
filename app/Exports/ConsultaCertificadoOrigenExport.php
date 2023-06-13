<?php

namespace App\Exports;

use App\Http\Controllers\reporte\ReporteCertificadoOrigenController;
use Illuminate\Contracts\View\View;
use App\Models\ConsultaReporteCertificadosOrigen;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class ConsultaCertificadoOrigenExport implements FromView, ShouldAutoSize, WithStyles,WithDrawings
{
    use Exportable;

    private $regional;
    private $fechainicio;
    private $fechafin;
    private $solicitante;
    private $certificado;
    private $totalRegistros; // Define the property here


    public function __construct($regional, $fechainicio, $fechafin, $solicitante, $certificado)
    {
        $this->regional = $regional;
        $this->fechainicio = $fechainicio;
        $this->fechafin = $fechafin;
        $this->solicitante = $solicitante;
        $this->certificado = $certificado;
        $this->totalRegistros = $this->getTotalRegistros(); // Assign the value here

    }
    public function view(): View
    {
        $busqueda = ConsultaReporteCertificadosOrigen::consultaCertificadoOrigen(
            $this->regional,
            $this->fechainicio,
            $this->fechafin,
            $this->solicitante,
            $this->certificado
        );

        return view('exports.ConsultaReporteCertificadosOrigen', ['busqueda' => $busqueda]);
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

        $sheet->setCellValue('A2', 'REPORTE CERTIFICADO DE ORIGEN');

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
        return ConsultaReporteCertificadosOrigen::consultaCertificadoOrigen(
            $this->regional,
            $this->fechainicio,
            $this->fechafin,
            $this->solicitante,
            $this->certificado
        )->count();
    }
}
