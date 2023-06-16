<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ConsultaReporteArticulos extends Model
{
    public static function consultaArticulos($palabraclave, $fechainicio, $fechafin, $regional, $material, $solicitante)
    {

        $reporteArticulo = DB::table('requests as r')
            ->select(
                'r.delivery_date as fecha_entrega',
                'r.nro_solicitud',
                'u.name as solicitante',
                'u1.name as administrador',
                'd.name as departamento',
                's.description as articulo',
                'sq.amount as pedido',
                'sq.amount_delivered as entregado',
                'sq.total_delivered as total_entregado',
                's.code as codigo',
                'm.code',
                'r.created_at'
            )
            ->leftJoin('subarticle_requests as sq', 'r.id', '=', 'sq.request_id')
            ->leftJoin('users as u', 'r.user_id', '=', 'u.id')
            ->leftJoin('users as u1', 'r.admin_id', '=', 'u1.id')
            ->leftJoin('subarticles as s', 's.id', '=', 'sq.subarticle_id')
            ->leftJoin('departments as d', 'd.id', '=', 'u.department_id')
            ->leftJoin('materials as m', 's.material_id', '=', 'm.id')
            ->whereNotNull('sq.observacion')
            ->where(function ($query) use ($regional, $solicitante, $palabraclave, $fechainicio, $fechafin, $material) {
                $query->where(function ($query) use ($regional, $solicitante, $material, $palabraclave) {
                    $query->where('s.description', 'like', '%' . $palabraclave . '%')
                        ->where('d.name', 'like', '%' . $regional . '%')
                        ->where('u.name', 'like', '%' . $solicitante . '%')
                        ->where('m.description', 'like', '%' . $material . '%');
                })
                    ->where(function ($query) use ($fechainicio, $fechafin) {
                        if (!empty($fechainicio) && !empty($fechafin)) {
                            $query->whereBetween('r.delivery_date', [$fechainicio, $fechafin]);

                        }
                    });
            })
            ->orderBy('r.created_at')
            ->orderBy('s.description')
            ->get();
        return $reporteArticulo;
    }
}
