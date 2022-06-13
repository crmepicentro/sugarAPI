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
    public function verificarEstadoSeguimientoPostVentas($ordTaller)
    {
        $orden_taller = Servicios3sController::consultaApiCabecera_orden($ordTaller);
        $orden = null;
        if($orden_taller['estado'] == 'COMPLETO' || $orden_taller['estado'] == 'INCOMPLETO'){
            $ordens = DetalleGestionOportunidades::where('s3s_codigo_seguimiento', $ordTaller)->get();
            echo "<ul>";
            foreach ($ordens as $orden) {
                foreach ($orden_taller['detalle'] as $detalle) {
                    //dd($detalle['ordTaller'] ,$orden->codServ,$orden_taller, $ordens);
                    if($detalle['codServ'] == $orden->codServ){
                        $orden->s3s_codigo_estado_taller = $orden_taller['header']['codEstOrdTaller'];
                        $orden->save();
                    }
                }

            }
        }
    }
}
