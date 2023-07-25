<?php

namespace App\Http\Controllers\Excel\ReporteArticulos;

use App\Exports\ConsultaArticulosExport;
use App\Http\Controllers\Controller;
use App\Models\ConsultaReporteArticulos;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelReporteArticulos extends Controller
{
    public function ExcelReportearticulos(Request $request)
    {
        $palabraclave = $request->input('palabraclave');
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $regional = $request->input('regional');
        $solicitante = $request->input('solicitante');
        $material = $request->input('material');

        return Excel::download(new ConsultaArticulosExport($palabraclave, $fechainicio, $fechafin, $regional, $material, $solicitante), 'ReporteArticulos.xlsx');
    }
    public function PDFReporteArticulos(Request $request)
    {
        $pdf = app('dompdf.wrapper');

        $palabraclave = $request->input('palabraclave');
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $regional = $request->input('regional');
        $material = $request->input('material');
        $solicitante = $request->input('solicitante');

        $busqueda = ConsultaReporteArticulos::consultaArticulos($palabraclave, $fechainicio, $fechafin, $regional, $material, $solicitante);
        $pdf = $pdf->loadView('exports/PDF/PDFConsultaReporteArticulos', compact('busqueda'));
        return $pdf->stream('ReporteArticulos.pdf');
    }
}
