<?php

namespace App\Http\Controllers\reporte;

use App\Models\ConsultaReporteArticulos;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReporteArticulosController extends Controller
{
  public function busquedaArticulos()
  {
    try {
      DB::beginTransaction();
      $palabraclave = request('palabraclave');
      $fechainicio = request('fechainicio');
      $fechafin = request('fechafin');
      $regional = request('regional');
      $material = request('material');
      $solicitante = request('solicitante');

      $busqueda = ConsultaReporteArticulos::consultaArticulos($palabraclave, $fechainicio, $fechafin, $regional, $material, $solicitante);
      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => 'Consulta realizada con exito',
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

          $material = DB::table('materials')
              ->select('description')
              ->get();

          DB::commit();
          return response()->json([
              'status' => 'success',
              'message' => 'Consulta realizada con exito',
              'regional' => $regional,
              'solicitante' => $solicitante,
              'material' => $material,
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
