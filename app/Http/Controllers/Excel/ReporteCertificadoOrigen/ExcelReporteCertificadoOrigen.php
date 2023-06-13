<?php

namespace App\Http\Controllers\Excel\ReporteCertificadoOrigen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ConsultaCertificadoOrigenExport;

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
        $export = new ConsultaCertificadoOrigenExport($regional, $fechainicio, $fechafin, $solicitante, $certificado);

        return Excel::download($export, 'ReporteCertificadoOrigen.xlsx');
    }
}
