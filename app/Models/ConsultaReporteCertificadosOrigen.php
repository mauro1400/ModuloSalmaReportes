<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ConsultaReporteCertificadosOrigen extends Model
{
    public static function consultaCerificadoOrigen($regional, $fechainicio, $fechafin, $solicitante, $certificado)
    {
        $reporteCertificadoOrigen =  DB::table(function ($query) {
            $query->select(
                'r.delivery_date as fecha_entrega',
                'r.nro_solicitud',
                'u.name as solicitante',
                'u1.name as administrador',
                'd.name as departamento',
                's.description as articulo',
                'sq.amount as pedido',
                'sq.amount_delivered as entregado',
                'sq.total_delivered as total_entregado',
                'sq.observacion',
                DB::raw("(LENGTH(sq.observacion) - LENGTH(REPLACE(sq.observacion, '-', ''))) / LENGTH('-') as del"),
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(sq.observacion, '-', 2), '-', -1) as al")
            )
                ->from('requests as r')
                ->leftJoin('subarticle_requests as sq', 'r.id', '=', 'sq.request_id')
                ->leftJoin('users as u', 'r.user_id', '=', 'u.id')
                ->leftJoin('users as u1', 'r.admin_id', '=', 'u1.id')
                ->leftJoin('subarticles as s', 's.id', '=', 'sq.subarticle_id')
                ->leftJoin('departments as d', 'd.id', '=', 'u.department_id')
                ->whereNotNull('sq.observacion');
        }, 't')
            ->select('t.*', DB::raw('(((t.al-t.del)+1)/25) as certificados'))
            ->where(function ($query) use ($regional, $solicitante, $certificado, $fechainicio, $fechafin) {
                $query->where(function ($query) use ($regional, $solicitante, $certificado) {
                    $query->where('t.departamento', 'like', '%' . $regional . '%')
                        ->where('t.solicitante', 'like', '%' . $solicitante . '%')
                        ->where('t.articulo', 'like', '%' . $certificado . '%');
                })
                    ->orWhereBetween('t.fecha_entrega', [$fechainicio, $fechafin]);
            })
            ->whereNotNull('t.al')
            ->get();

        return $reporteCertificadoOrigen;
    }
}
