<?php

namespace App\Http\Controllers\reporte;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ConsultaReporteCertificadosOrigen;

class ReporteCertificadoOrigenController extends Controller
{
    public function busquedaCertificadoOrigen()
    {
        try {
            DB::beginTransaction();
            $regional = request('regional');
            $fechainicio = request('fechainicio');
            $fechafin = request('fechafin');
            $solicitante = request('solicitante');
            $certificado  = request('certificado');
            $busqueda = ConsultaReporteCertificadosOrigen::consultaCerificadoOrigen($regional, $fechainicio, $fechafin, $solicitante, $certificado);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Datos Chofer',
                'busqueda' => $busqueda,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
