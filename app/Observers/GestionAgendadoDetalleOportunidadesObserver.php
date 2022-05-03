<?php

namespace App\Observers;

use App\Models\GestionAgendadoDetalleOportunidades;

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
