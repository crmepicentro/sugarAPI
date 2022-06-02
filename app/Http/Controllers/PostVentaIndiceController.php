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
        $porte_paginacion = 20;

        $data_list = "SELECT
    'Original' as select_original,
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
  (SELECT COUNT(conteo_autos) as cuenta_autos FROM (SELECT DISTINCT con_autos.placa AS conteo_autos FROM sugarcrm.pvt_detalle_gestion_oportunidades con_detaut INNER JOIN sugarcrm.pvt_autos con_autos       ON (con_detaut.auto_id = con_autos.id) WHERE (con_detaut.facturado = \'N\' AND con_autos.propietario_id = pvt_propietarios.id) GROUP BY con_autos.placa) AS TEMPAUTO) AS cantidad_autos,
  (SELECT COUNT(DISTINCT ordTaller) FROM pvt_detalle_gestion_oportunidades AS CAOD WHERE CAOD.facturado = 'N' AND CAOD.gestion_tipo IN ('nuevo','cita','recordatorio','cita_noshow') AND CAOD.auto_id in (pvt_autos.id) ) AS cantidad_ordenes,
  count(pvt_autos.id) AS cant_op_p,
  max(pvt_detalle_gestion_oportunidades.ordFchaCierre) as ordFchaCierre
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
            ->orderByRaw('max(STR_TO_DATE(pvt_detalle_gestion_oportunidades.ordFchaCierre,\'%d-%m-%Y\'))', 'DESC')
            ->orderByRaw('FIELD(pvt_detalle_gestion_oportunidades.gestion_tipo, \'recordatorio\', \'cita\', \'nuevo\', \'perdido\')')
            ->orderby('pvt_detalle_gestion_oportunidades.agendado_fecha', 'ASC')
            ->orderbyRaw('MIN(pvt_detalle_gestion_oportunidades.gestion_fecha)', 'DESC')
            ->selectRaw('
            \'lista_oportunidades\' as select_original,
            pvt_propietarios.id as id_p,
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
  (SELECT COUNT(conteo_autos) as cuenta_autos FROM (SELECT DISTINCT con_autos.placa AS conteo_autos FROM sugarcrm.pvt_detalle_gestion_oportunidades con_detaut INNER JOIN sugarcrm.pvt_autos con_autos       ON (con_detaut.auto_id = con_autos.id) WHERE (con_detaut.facturado = \'N\' AND con_autos.propietario_id = pvt_propietarios.id) GROUP BY con_autos.placa) AS TEMPAUTO) AS cantidad_autos,
  (SELECT COUNT(DISTINCT ordTaller) FROM pvt_detalle_gestion_oportunidades AS CAOD WHERE CAOD.facturado = \'N\' AND CAOD.gestion_tipo IN (\'nuevo\',\'cita\',\'recordatorio\',\'cita_noshow\') AND CAOD.auto_id in (pvt_autos.id) ) AS cantidad_ordenes,
  count(pvt_autos.id) AS cant_op_p,
  max(pvt_detalle_gestion_oportunidades.ordFchaCierre) as ordFchaCierre
            ')
            ->havingRaw("primer_gestion_v2 = '' ")
            ->paginate(
                $perPage = $porte_paginacion, $columns = ['*'], $pageName = 'gestion_p'
            );
        ;
        $lista_recordatorio = Auto::join((new Propietario)->getTable(), 'pvt_autos.propietario_id', '=', 'pvt_propietarios.id')
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
            ->orderByRaw('max(STR_TO_DATE(pvt_detalle_gestion_oportunidades.ordFchaCierre,\'%d-%m-%Y\'))', 'DESC')
            ->orderByRaw('FIELD(pvt_detalle_gestion_oportunidades.gestion_tipo, \'recordatorio\', \'cita\', \'nuevo\', \'perdido\')')
            ->orderby('pvt_detalle_gestion_oportunidades.agendado_fecha', 'ASC')
            ->orderbyRaw('MIN(pvt_detalle_gestion_oportunidades.gestion_fecha)', 'DESC')
            ->selectRaw('
            \'lista_recordatorio\' as select_original,
            pvt_propietarios.id as id_p,
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
  (SELECT COUNT(conteo_autos) as cuenta_autos FROM (SELECT DISTINCT con_autos.placa AS conteo_autos FROM sugarcrm.pvt_detalle_gestion_oportunidades con_detaut INNER JOIN sugarcrm.pvt_autos con_autos       ON (con_detaut.auto_id = con_autos.id) WHERE (con_detaut.facturado = \'N\' AND con_autos.propietario_id = pvt_propietarios.id) GROUP BY con_autos.placa) AS TEMPAUTO) AS cantidad_autos,
  (SELECT COUNT(DISTINCT ordTaller) FROM pvt_detalle_gestion_oportunidades AS CAOD WHERE CAOD.facturado = \'N\' AND CAOD.gestion_tipo IN (\'nuevo\',\'cita\',\'recordatorio\',\'cita_noshow\') AND CAOD.auto_id in (pvt_autos.id) ) AS cantidad_ordenes,
  count(pvt_autos.id) AS cant_op_p,
  max(pvt_detalle_gestion_oportunidades.ordFchaCierre) as ordFchaCierre
            ')
            ->havingRaw("primer_gestion_v2 <>'' ")
            ->gestiontipo('recordatorio')
            ->paginate(
                $perPage = $porte_paginacion, $columns = ['*'], $pageName = 'recorda_p'
            );
        ;
        $lista_citas = Auto::join((new Propietario)->getTable(), 'pvt_autos.propietario_id', '=', 'pvt_propietarios.id')
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
            ->orderByRaw('max(STR_TO_DATE(pvt_detalle_gestion_oportunidades.ordFchaCierre,\'%d-%m-%Y\'))', 'DESC')
            ->orderByRaw('FIELD(pvt_detalle_gestion_oportunidades.gestion_tipo, \'recordatorio\', \'cita\', \'nuevo\', \'perdido\')')
            ->orderby('pvt_detalle_gestion_oportunidades.agendado_fecha', 'ASC')
            ->orderbyRaw('MIN(pvt_detalle_gestion_oportunidades.gestion_fecha)', 'DESC')
            ->selectRaw('
            \'lista_recordatorio\' as select_original,
            pvt_propietarios.id as id_p,
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
  (SELECT COUNT(conteo_autos) as cuenta_autos FROM (SELECT DISTINCT con_autos.placa AS conteo_autos FROM sugarcrm.pvt_detalle_gestion_oportunidades con_detaut INNER JOIN sugarcrm.pvt_autos con_autos       ON (con_detaut.auto_id = con_autos.id) WHERE (con_detaut.facturado = \'N\' AND con_autos.propietario_id = pvt_propietarios.id) GROUP BY con_autos.placa) AS TEMPAUTO) AS cantidad_autos,
  (SELECT COUNT(DISTINCT ordTaller) FROM pvt_detalle_gestion_oportunidades AS CAOD WHERE CAOD.facturado = \'N\' AND CAOD.gestion_tipo IN (\'nuevo\',\'cita\',\'recordatorio\',\'cita_noshow\') AND CAOD.auto_id in (pvt_autos.id) ) AS cantidad_ordenes,
  count(pvt_autos.id) AS cant_op_p,
  max(pvt_detalle_gestion_oportunidades.ordFchaCierre) as ordFchaCierre
            ')
            ->havingRaw("primer_gestion_v2 <>'' ")
            ->gestiontipo('cita')
            ->paginate(
                $perPage = $porte_paginacion, $columns = ['*'], $pageName = 'recorda_p'
            );
        ;
        $lista_consultageneral = Auto::join((new Propietario)->getTable(), 'pvt_autos.propietario_id', '=', 'pvt_propietarios.id')
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
            ->orderByRaw('max(STR_TO_DATE(pvt_detalle_gestion_oportunidades.ordFchaCierre,\'%d-%m-%Y\'))', 'DESC')
            ->orderByRaw('FIELD(pvt_detalle_gestion_oportunidades.gestion_tipo, \'recordatorio\', \'cita\', \'nuevo\', \'perdido\')')
            ->orderby('pvt_detalle_gestion_oportunidades.agendado_fecha', 'ASC')
            ->orderbyRaw('MIN(pvt_detalle_gestion_oportunidades.gestion_fecha)', 'DESC')
            ->selectRaw('
             \'lista_consultageneral\' as select_original,
            pvt_propietarios.id as id_p,
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
  (SELECT COUNT(conteo_autos) as cuenta_autos FROM (SELECT DISTINCT con_autos.placa AS conteo_autos FROM sugarcrm.pvt_detalle_gestion_oportunidades con_detaut INNER JOIN sugarcrm.pvt_autos con_autos       ON (con_detaut.auto_id = con_autos.id) WHERE (con_detaut.facturado = \'N\' AND con_autos.propietario_id = pvt_propietarios.id) GROUP BY con_autos.placa) AS TEMPAUTO) AS cantidad_autos,
  (SELECT COUNT(DISTINCT ordTaller) FROM pvt_detalle_gestion_oportunidades AS CAOD WHERE CAOD.facturado = \'N\' AND CAOD.gestion_tipo IN (\'nuevo\',\'cita\',\'recordatorio\',\'cita_noshow\') AND CAOD.auto_id in (pvt_autos.id) ) AS cantidad_ordenes,
  count(pvt_autos.id) AS cant_op_p,
  max(pvt_detalle_gestion_oportunidades.ordFchaCierre) as ordFchaCierre
            ')
            ->nombrepropietario($request->search_cliente)
            ->chasis($request->search_chasis)
            ->placa($request->search_placa)
            ->nombreasesor($request->search_asesor)
            ->ordtaller($request->search_orden)
            ->oportunidades($request->search_oportunidades)
            ->gestiontipo($request->search_estados)
            ->gestionfecha($request->search_fechaGestion_from, $request->search_fechaGestion_to)
            ->facturafecha($request->search_fechaFactura_from, $request->search_fechaFactura_to)
            ->citafecha($request->search_fechacita_from, $request->search_fechacita_to)
            ->paginate(
                $perPage = 10, $columns = ['*'], $pageName = 'consugeneral_p'
            );
        ;
        //dd($request->all());
        //dd($autos->first());
        return view('postventas.indexList', compact('lista_oportunidades','lista_recordatorio','lista_consultageneral','lista_citas'));
    }
}
