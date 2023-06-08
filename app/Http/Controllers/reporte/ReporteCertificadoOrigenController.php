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
            if (empty($certificado)) {
                $certificado = "CERTIFICADO";
            }
            $busqueda = ConsultaReporteCertificadosOrigen::consultaCerificadoOrigen($regional, $fechainicio, $fechafin, $solicitante, $certificado);

            $departments = DB::table('departments')->get();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Consulta realizada con exito',
                'busqueda' => $busqueda,
                'regional' => $departments,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function filtrosBusqueda()
    {
        try {
            DB::beginTransaction();

            $regional = DB::table('departments')
                ->select('name')
                ->get();

            $solicitante = DB::table('users')
                ->select('name')
                ->where('name', '!=', 'Administrador')
                ->get();

            $certificado = DB::table('subarticles')
                ->select('description')
                ->where('description', 'like', 'CERTIFICADO%')
                ->get();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Consulta realizada con exito',
                'regional' => $regional,
                'solicitante' => $solicitante,
                'certificado' => $certificado,
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
