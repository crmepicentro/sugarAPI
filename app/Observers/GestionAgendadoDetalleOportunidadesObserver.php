<?php

namespace App\Observers;

use App\Models\DetalleGestionOportunidades;
use App\Models\GestionAgendadoDetalleOportunidades;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GestionAgendadoDetalleOportunidadesObserver
{
    /**
     * Borrar todos los elementos de GestionCita.
     *
     * @param  \App\Models\Gestion\GestionCita  $gestionCita
     * @return void
     */
    private function BorradoGestionesAntiguas(GestionAgendadoDetalleOportunidades $gestionAgendadoDetalleOportunidades){
        $gestionesDetalleop = GestionAgendadoDetalleOportunidades::
        where('detalle_gestion_oportunidad_id',$gestionAgendadoDetalleOportunidades->detalle_gestion_oportunidad_id)
        //->where('gestion_agendado_id',$gestionAgendadoDetalleOportunidades->gestion_agendado_id) // se borra incluso agendas de otras oportunidades realizadas por otras personas
            ->get();
        foreach ($gestionesDetalleop as $gestion) {
            $gestion->activo = 1;
            $gestion->save();
            $gestion->delete();
        }
    }
    /**
     * Handle the GestionAgendadoDetalleOportunidades "created" event.
     *
     * @param  \App\Models\GestionAgendadoDetalleOportunidades  $gestionAgendadoDetalleOportunidades
     * @return void
     */
    public function creating(GestionAgendadoDetalleOportunidades $gestionAgendadoDetalleOportunidades)
    {
        $this->BorradoGestionesAntiguas($gestionAgendadoDetalleOportunidades);
    }

    public function created(GestionAgendadoDetalleOportunidades $gestionAgendadoDetalleOportunidades)
    {
        //'nuevo','cita','recordatorio','perdido','perdido_taller','cita_ok','cita_noshow','borrar_cita'
        Log::info($gestionAgendadoDetalleOportunidades->tipo_gestion);
        if ($gestionAgendadoDetalleOportunidades->tipo_gestion == 'borrar_cita') { // cuando se borra regresa a la oportunidad sin cita
            //Log::alert(print_r($gestionAgendadoDetalleOportunidades->detalleoportunidad, true));
            DetalleGestionOportunidades::where('id', $gestionAgendadoDetalleOportunidades->detalleoportunidad->id)
                ->update([
                    'gestion_tipo' => 'nuevo',
                    //'gestion_agendado_id' => null,
                    //'agencia_cita' => null,
                    //'observacion_cita' => 'Borrar cita',
                    's3s_codigo_seguimiento' => null,
                    's3s_codigo_estado_taller' => null,
                    'oportunidad_id' => null,
                    'cita_fecha' => null,
                ]);
            Log::info('borrar_cita');
        }elseif ($gestionAgendadoDetalleOportunidades->tipo_gestion == 'perdido') {
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->perdida_fecha = Carbon::now();
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->perdida_agente = 1;//auth()->user()->id,
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->perdida_motivo = $gestionAgendadoDetalleOportunidades->motivo_perdida;
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->gestion_fecha = Carbon::now();
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->gestion_tipo = $gestionAgendadoDetalleOportunidades->tipo_gestion;
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->save();
            Log::info('perdido');
        }elseif ($gestionAgendadoDetalleOportunidades->tipo_gestion == 'recordatorio') {
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->gestion_fecha = Carbon::now();
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->agendado_fecha = $gestionAgendadoDetalleOportunidades->fecha_agendamiento;
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->gestion_tipo = $gestionAgendadoDetalleOportunidades->tipo_gestion;
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->save();
            Log::info('recordatorio');
        }else{
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->gestion_fecha = Carbon::now();
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->gestion_tipo = $gestionAgendadoDetalleOportunidades->tipo_gestion;
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->save();
            Log::info('else');
        }
    }

    /**
     * Handle the GestionAgendadoDetalleOportunidades "updated" event.
     *
     * @param  \App\Models\GestionAgendadoDetalleOportunidades  $gestionAgendadoDetalleOportunidades
     * @return void
     */
    public function updating(GestionAgendadoDetalleOportunidades $gestionAgendadoDetalleOportunidades)
    {
       // $this->BorradoGestionesAntiguas($gestionAgendadoDetalleOportunidades);
    }

    /**
     * Handle the GestionAgendadoDetalleOportunidades "deleted" event.
     *
     * @param  \App\Models\GestionAgendadoDetalleOportunidades  $gestionAgendadoDetalleOportunidades
     * @return void
     */
    public function deleted(GestionAgendadoDetalleOportunidades $gestionAgendadoDetalleOportunidades)
    {
        //
    }

    /**
     * Handle the GestionAgendadoDetalleOportunidades "restored" event.
     *
     * @param  \App\Models\GestionAgendadoDetalleOportunidades  $gestionAgendadoDetalleOportunidades
     * @return void
     */
    public function restored(GestionAgendadoDetalleOportunidades $gestionAgendadoDetalleOportunidades)
    {
        //
    }

    /**
     * Handle the GestionAgendadoDetalleOportunidades "force deleted" event.
     *
     * @param  \App\Models\GestionAgendadoDetalleOportunidades  $gestionAgendadoDetalleOportunidades
     * @return void
     */
    public function forceDeleted(GestionAgendadoDetalleOportunidades $gestionAgendadoDetalleOportunidades)
    {
        //
    }
}
