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
  pvt_propietarios.nombre_propietario,
  pvt_propietarios.email_propietario,
  pvt_propietarios.telefono_domicilio,
  MIN(pvt_gestion_agendado_detalle_op.created_at) AS Min_created_at_masterGestion,
  MIN(pvt_gestion_agendados.created_at) AS Min_created_atDetalleGestion,
  pvt_propietarios.id,
  COUNT(pvt_autos.id) AS Count_id_autos
FROM pvt_gestion_agendado_detalle_op pvt_gestion_agendado_detalle_op
  INNER JOIN pvt_gestion_agendados pvt_gestion_agendados
    ON pvt_gestion_agendado_detalle_op.gestion_agendado_id = pvt_gestion_agendados.id
  RIGHT OUTER JOIN pvt_detalle_gestion_oportunidades pvt_detalle_gestion_oportunidades
    ON pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id = pvt_detalle_gestion_oportunidades.id
  INNER JOIN pvt_autos pvt_autos
    ON pvt_detalle_gestion_oportunidades.auto_id = pvt_autos.id
  INNER JOIN pvt_propietarios pvt_propietarios
    ON pvt_autos.propietario_id = pvt_propietarios.id
GROUP BY pvt_propietarios.nombre_propietario,
         pvt_propietarios.email_propietario,
         pvt_propietarios.telefono_domicilio,
         pvt_propietarios.id";

        $lista_oportunidades = \DB::select($data_list, ['N']);

        return view('postventas.indexList', compact('lista_oportunidades'));
    }
}
