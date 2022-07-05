<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
use App\Models\DetalleGestionOportunidades;
use App\Models\GestionAgendado;

class SeguimientoPostVentasController extends Controller
{
    /**
     * verificar estado de seguimiento de post ventas
     *
     * @return \Illuminate\Http\Response
     */
    public function verificarEstadoSeguimientoPostVentas($ordTaller,$gestion_agendado_id)
    {
        $orden_taller = Servicios3sController::consultaApiCabecera_orden($ordTaller);
        $gestion = GestionAgendado::where('id',$gestion_agendado_id)->firstorfail();
        if($orden_taller['estado'] == 'COMPLETO'){
            $ordens = $gestion->detalleoportunidadcitas;
            if($orden_taller['estado'] == 'COMPLETO' || $orden_taller['estado'] == 'INCOMPLETO'){
                $ordens = DetalleGestionOportunidades::where('s3s_codigo_seguimiento', $ordTaller)->get();
                echo "<ul>";
                foreach ($ordens as $orden) {
                    foreach ($orden_taller['detalle'] as $detalle) {
                        if($detalle['codServ'] == $orden->codServ){
                            dd('Compara ok', $detalle['codServ'] , $orden->codServ,'Otro',$orden_taller['header']['codEstOrdTaller'],$gestion);
                            $orden->s3s_codigo_estado_taller = $orden_taller['header']['codEstOrdTaller'];
                            $orden->save();
                        }
                    }
                }
            }
            return view('postventas.oportunidades.seguimiento' ,compact('orden_taller','ordens',));
        }
        $mensaje = 'El auto no se ha recibido aun';
        dd($gestion);
        return view('postventas.oportunidades.seguimiento' ,compact('orden_taller','ordens',));

    }
}
