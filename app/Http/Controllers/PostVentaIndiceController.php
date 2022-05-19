<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\DetalleGestionOportunidades;
use App\Models\GestionAgendadoDetalleOportunidades;
use App\Models\Propietario;
use Illuminate\Http\Request;

class PostVentaIndiceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $data_list = "SELECT
  pvt_propietarios.id,
  pvt_propietarios.nombre_propietario,
  pvt_propietarios.email_propietario,
  pvt_propietarios.email_propietario_2,
  pvt_propietarios.telefono_domicilio,
  pvt_propietarios.telefono_trabajo,
  pvt_propietarios.telefono_celular,
  pvt_detalle_gestion_oportunidades.cita_fecha,
  pvt_detalle_gestion_oportunidades.agendado_fecha,
  pvt_detalle_gestion_oportunidades.ganado_fecha,
  pvt_detalle_gestion_oportunidades.gestion_tipo,
  pvt_detalle_gestion_oportunidades.s3s_codigo_seguimiento,
  MIN(IFNULL(pvt_gestion_agendado_detalle_op.created_at, '')) AS primer_gestion_v2,
  (SELECT
      interno1.tipo_gestion
    FROM pvt_gestion_agendado_detalle_op interno1
    WHERE interno1.detalle_gestion_oportunidad_id IN (SELECT
        oportunidades_inter_ca1.id
      FROM pvt_detalle_gestion_oportunidades oportunidades_inter_ca1
        INNER JOIN pvt_autos auto_inter_ca1
          ON oportunidades_inter_ca1.auto_id = auto_inter_ca1.id
      WHERE pvt_detalle_gestion_oportunidades.facturado = 'N'
      AND oportunidades_inter_ca1.agendado_fecha = pvt_detalle_gestion_oportunidades.agendado_fecha
      AND auto_inter_ca1.id = pvt_autos.id
      AND oportunidades_inter_ca1.ganado_fecha = pvt_detalle_gestion_oportunidades.ganado_fecha
      AND oportunidades_inter_ca1.gestion_tipo = pvt_detalle_gestion_oportunidades.gestion_tipo
      AND oportunidades_inter_ca1.cita_fecha = pvt_detalle_gestion_oportunidades.cita_fecha
      AND oportunidades_inter_ca1.s3s_codigo_seguimiento = pvt_detalle_gestion_oportunidades.s3s_codigo_seguimiento)
    ORDER BY interno1.created_at DESC
    LIMIT 1) AS primer_gestion_estado_v2,
  pvt_autos.id,
  count(pvt_autos.id) AS cantidad_autos
FROM pvt_autos pvt_autos
  INNER JOIN pvt_propietarios pvt_propietarios
    ON pvt_autos.propietario_id = pvt_propietarios.id
  INNER JOIN pvt_detalle_gestion_oportunidades pvt_detalle_gestion_oportunidades
    ON pvt_detalle_gestion_oportunidades.auto_id = pvt_autos.id AND pvt_detalle_gestion_oportunidades.facturado = 'N'
  LEFT OUTER JOIN pvt_gestion_agendado_detalle_op pvt_gestion_agendado_detalle_op
    ON pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id = pvt_detalle_gestion_oportunidades.id
GROUP BY pvt_propietarios.id,
         pvt_propietarios.nombre_propietario,
         pvt_propietarios.email_propietario,
         pvt_propietarios.email_propietario_2,
         pvt_propietarios.telefono_domicilio,
         pvt_propietarios.telefono_trabajo,
         pvt_propietarios.telefono_celular,
         pvt_detalle_gestion_oportunidades.agendado_fecha,
         pvt_detalle_gestion_oportunidades.ganado_fecha,
         pvt_detalle_gestion_oportunidades.gestion_tipo,
         pvt_detalle_gestion_oportunidades.cita_fecha,
         pvt_detalle_gestion_oportunidades.s3s_codigo_seguimiento,
         pvt_autos.id
ORDER BY FIELD(pvt_detalle_gestion_oportunidades.gestion_tipo, 'recordatorio', 'cita', 'nuevo', 'perdido'), pvt_detalle_gestion_oportunidades.agendado_fecha ASC,MIN(pvt_detalle_gestion_oportunidades.gestion_fecha) DESC limit 100";

        // $lista_oportunidades = \DB::select($data_list, ['N']);
        $lista_oportunidades = Auto::join((new Propietario)->getTable(), 'pvt_autos.propietario_id', '=', 'pvt_propietarios.id')
            ->join((new DetalleGestionOportunidades)->getTable(), function ($join) {
                $join->on('pvt_detalle_gestion_oportunidades.auto_id', '=', 'pvt_autos.id')
                    ->where('pvt_detalle_gestion_oportunidades.facturado', '=', 'N');
            })
            ->leftjoin((new GestionAgendadoDetalleOportunidades)->getTable(), 'pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id', '=', 'pvt_detalle_gestion_oportunidades.id')
            ->groupBy('pvt_propietarios.id')
            ->groupBy('pvt_propietarios.nombre_propietario')
            ->groupBy('pvt_propietarios.email_propietario')
            ->groupBy('pvt_propietarios.email_propietario_2')
            ->groupBy('pvt_propietarios.telefono_domicilio')
            ->groupBy('pvt_propietarios.telefono_trabajo')
            ->groupBy('pvt_propietarios.telefono_celular')
            ->groupBy('pvt_detalle_gestion_oportunidades.agendado_fecha')
            ->groupBy('pvt_detalle_gestion_oportunidades.ganado_fecha')
            ->groupBy('pvt_detalle_gestion_oportunidades.gestion_tipo')
            ->groupBy('pvt_detalle_gestion_oportunidades.cita_fecha')
            ->groupBy('pvt_detalle_gestion_oportunidades.s3s_codigo_seguimiento')
            ->groupBy('pvt_autos.id')
            ->orderByRaw('FIELD(pvt_detalle_gestion_oportunidades.gestion_tipo, \'recordatorio\', \'cita\', \'nuevo\', \'perdido\')')
            ->orderby('pvt_detalle_gestion_oportunidades.agendado_fecha', 'ASC')
            ->orderbyRaw('MIN(pvt_detalle_gestion_oportunidades.gestion_fecha)', 'DESC')
            ->selectRaw('
            pvt_propietarios.id,
  pvt_propietarios.nombre_propietario,
  pvt_propietarios.email_propietario,
  pvt_propietarios.email_propietario_2,
  pvt_propietarios.telefono_domicilio,
  pvt_propietarios.telefono_trabajo,
  pvt_propietarios.telefono_celular,
  pvt_detalle_gestion_oportunidades.cita_fecha,
  pvt_detalle_gestion_oportunidades.agendado_fecha,
  pvt_detalle_gestion_oportunidades.ganado_fecha,
  pvt_detalle_gestion_oportunidades.gestion_tipo,
  pvt_detalle_gestion_oportunidades.s3s_codigo_seguimiento,
  MIN(IFNULL(pvt_gestion_agendado_detalle_op.created_at, \'\')) AS primer_gestion_v2,
  \'Canada\' AS primer_gestion_estado_v2,
  pvt_autos.id,
  count(pvt_autos.id) AS cantidad_autos
            ')
            ->simplePaginate(13);
        ;
        //dd($autos->first());
        return view('postventas.indexList', compact('lista_oportunidades'));
    }
}
