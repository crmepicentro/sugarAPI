<?php

namespace App\Http\Controllers;

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
      WHERE oportunidades_inter_ca1.agendado_fecha = pvt_detalle_gestion_oportunidades.agendado_fecha
      AND auto_inter_ca1.id = pvt_autos.id
      AND oportunidades_inter_ca1.ganado_fecha = pvt_detalle_gestion_oportunidades.ganado_fecha
      AND oportunidades_inter_ca1.gestion_tipo = pvt_detalle_gestion_oportunidades.gestion_tipo
      AND oportunidades_inter_ca1.cita_fecha = pvt_detalle_gestion_oportunidades.cita_fecha
      AND oportunidades_inter_ca1.s3s_codigo_seguimiento = pvt_detalle_gestion_oportunidades.s3s_codigo_seguimiento)
    ORDER BY interno1.created_at DESC
    LIMIT 1) AS primer_gestion_estado_v2,
  pvt_autos.id
FROM pvt_autos pvt_autos
  INNER JOIN pvt_propietarios pvt_propietarios
    ON pvt_autos.propietario_id = pvt_propietarios.id
  INNER JOIN pvt_detalle_gestion_oportunidades pvt_detalle_gestion_oportunidades
    ON pvt_detalle_gestion_oportunidades.auto_id = pvt_autos.id
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
ORDER BY FIELD(pvt_detalle_gestion_oportunidades.gestion_tipo, 'recordatorio', 'cita', 'nuevo', 'perdido'), MIN(pvt_detalle_gestion_oportunidades.gestion_fecha) DESC limit 100";

        $lista_oportunidades = \DB::select($data_list, ['N']);

        return view('postventas.indexList', compact('lista_oportunidades'));
    }
}
