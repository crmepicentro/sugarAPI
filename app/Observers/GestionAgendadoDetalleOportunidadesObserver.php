<?php

namespace App\Observers;

use App\Models\GestionAgendadoDetalleOportunidades;
use Carbon\Carbon;

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
        if ($gestionAgendadoDetalleOportunidades->tipo_gestion == 'perdido') {
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->perdida_fecha = Carbon::now();
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->perdida_agente = 1;//auth()->user()->id,
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->perdida_motivo = $gestionAgendadoDetalleOportunidades->motivo_perdida;
            $gestionAgendadoDetalleOportunidades->detalleoportunidad->save();
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
