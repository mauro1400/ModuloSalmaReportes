<?php

namespace App\Http\Controllers\Excel\ReporteCertificadoOrigen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ConsultaCertificadoOrigenExport;
use App\Models\ConsultaReporteCertificadosOrigen;

class ExcelReporteCertificadoOrigen extends Controller
{
    public function ExcelReporteCertificadoOrigen(Request $request)
    {
        $regional = $request->input('regional');
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $solicitante = $request->input('solicitante');
        $certificado = $request->input('certificado');
        if (empty($certificado)) {
            $certificado = "CERTIFICADO";
        }

        return Excel::download(new ConsultaCertificadoOrigenExport($regional, $fechainicio, $fechafin, $solicitante, $certificado), 'ReporteCertificadoOrigen.xlsx');
    }

    public function PDFReporteCertificadoOrigen(Request $request)
    {
        $pdf = app('dompdf.wrapper');

        $regional = $request->input('regional');
        $fechafin = $request->input('fechafin');
        $fechainicio = $request->input('fechainicio');
        $solicitante = $request->input('solicitante');
        $certificado = $request->input('certificado');
        if (empty($certificado)) {
            $certificado = "CERTIFICADO";
        }

        $busqueda = ConsultaReporteCertificadosOrigen::consultaCertificadoOrigen($regional, $fechainicio, $fechafin, $solicitante, $certificado);
        $pdf = $pdf->loadView('exports/PDF/PDFConsultaReporteCertificadosOrigen', compact('busqueda'));
        return $pdf->stream('ReporteCertificadoOrigen.pdf');
    }
}
