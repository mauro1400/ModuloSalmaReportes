<?php

namespace App\Http\Controllers\reporte;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ConsultaReportePartidas;

class ReportePartidasController extends Controller
{/*
    public function inicio()
    {
        $codig = DB::table('materials')
            ->select('materials.code', DB::raw("CONCAT(materials.code,'-',materials.description) as codigo"))
            ->get();
        //dd(count($reportePartidas));
        return view('reporte.ReportePartidas.home', ['codig' => $codig]);
    }

    public function busquedaPartida()
    {
        try {
            $codig = DB::table('materials')
                ->select('materials.code', DB::raw("CONCAT(materials.code,'-',materials.description) as codigo"))
                ->get();

            $partida = request('partida');
            $reportePartidas = ConsultaReportePartidas::partida($partida);
            //dd(request('partida'));
            //dd($reportePartidas);
            return view('reporte.ReportePartidas.index', ['reportePartidas' => $reportePartidas, 'codig' => $codig]);
        } catch (\Exception $e) {
            return view('reporte.ReportePartidas.home', ["error" => $e->getMessage(), 'codig' => $codig]);
        }
    }

    public function exportarReportePartidas()
    {
        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("SENAVEX")
            ->setLastModifiedBy('SENAVEX') // última vez modificado por
            ->setTitle('Reporte Partidas');
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Reporte de Partidas");
        $hoy = now();

        $hoja->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $hoja->getPageSetup()->setScale(64);

        $cabecera1 = ["REPORTE DE PARTIDAS"];
        $hoja->fromArray($cabecera1, null, 'A2')->mergeCells('A2:L2')->getStyle('A2:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $cabeceraFecha = ["Fecha de Reporte: $hoy"];
        $hoja->fromArray($cabeceraFecha, null, 'A3')->mergeCells('A3:L3')->getStyle('A3:L3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $encabezado = [
            "Fecha Entrega", "Numero Solicitud", "Solicitante", "Administrador", "Departamento", "Articulo",
            "Pedido", "Entregado", "Total Entregado", "Codigo de Articulo", "Partida", "Creado el"
        ];
        $hoja->getStyle('A5:L5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('bacbe6');

        $hoja->getStyle('A5:L5')->getAlignment()->setWrapText(true);
        $borde = [

            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        $hoja->getStyle('A5:L5')->applyFromArray($borde);

        $hoja->getCell('A2')->getStyle()->getFont()->setSize(15);
        $hoja->getCell('A3')->getStyle()->getFont()->setSize(10);

        $hoja->fromArray($encabezado, null, 'A5');
        $hoja->getStyle('A5:L5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $hoja->getColumnDimension('A')->setWidth(12);
        $hoja->getColumnDimension('B')->setWidth(10);
        $hoja->getColumnDimension('C')->setWidth(25);
        $hoja->getColumnDimension('D')->setWidth(25);
        $hoja->getColumnDimension('E')->setWidth(25);
        $hoja->getColumnDimension('F')->setWidth(25);
        $hoja->getColumnDimension('H')->setWidth(12);
        $hoja->getColumnDimension('I')->setWidth(12);
        $hoja->getColumnDimension('J')->setWidth(12);
        $hoja->getColumnDimension('L')->setWidth(12);

        $partida = request('partida');
        $busqueda = ConsultaReportePartidas::partida($partida);
        $fila = 6;
        foreach ($busqueda as $item) {
            $hoja->setCellValue('A' . $fila, $item->fecha_entrega)->getStyle('A' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('B' . $fila, $item->nro_solicitud)->getStyle('B' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('C' . $fila, $item->solicitante)->getStyle('C' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('D' . $fila, $item->administrador)->getStyle('D' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('E' . $fila, $item->departamento)->getStyle('E' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('F' . $fila, $item->articulo)->getStyle('F' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('G' . $fila, $item->pedido)->getStyle('G' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('H' . $fila, $item->entregado)->getStyle('H' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('I' . $fila, $item->total_entregado)->getStyle('I' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('J' . $fila, $item->codigo)->getStyle('J' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('K' . $fila, $item->code)->getStyle('K' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->setCellValue('L' . $fila, $item->created_at)->getStyle('L' . $fila)->getBorders()->getallBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $hoja->getStyle('A' . $fila . ':L' . $fila)->getAlignment()->setWrapText(true);
            $fila++;
        }
        $logo = new MemoryDrawing();
        $logo->setName('Image');
        $logo->setDescription('Image');
        $logo->setImageResource(imagecreatefromjpeg(public_path('logo/logo_senavex.jpg')));
        $logo->setRenderingFunction(MemoryDrawing::RENDERING_JPEG);
        $logo->setMimeType(MemoryDrawing::MIMETYPE_DEFAULT);
        $logo->setHeight(80);
        $logo->setCoordinates('A1');
        $logo->setWorksheet($hoja);

        $nombreDelDocumento = "Reporte_Partida.$hoy.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        //return Excel::download(new ReportecExport, "reporte.$hoy.xlsx");
    }*/
}
