<?php

namespace App\Observers;

use App\Models\Gestion\GestionCita;

class GestionCitaObserver
{
    /**
     * Borrar todos los elementos de GestionCita.
     *
     * @param  \App\Models\Gestion\GestionCita  $gestionCita
     * @return void
     */
    public function BorradoGestionesAntiguas(GestionCita $gestionCita){
        $gestiones = GestionCita::where('detalle_gestion_oportunidad_id',$gestionCita->detalle_gestion_oportunidades_id)->get();
        foreach ($gestiones as $gestion) {
            $gestion->delete();
        }
    }
    /**
     * Handle the GestionCita "created" event.
     *
     * @param  \App\Models\Gestion\GestionCita  $gestionCita
     * @return void
     */
    public function creating(GestionCita $gestionCita)
    {
        $this->BorradoGestionesAntiguas($gestionCita);
    }

    /**
     * Handle the GestionCita "updated" event.
     *
     * @param  \App\Models\Gestion\GestionCita  $gestionCita
     * @return void
     */
    public function updating(GestionCita $gestionCita)
    {
        $this->BorradoGestionesAntiguas($gestionCita);
    }

    /**
     * Handle the GestionCita "deleted" event.
     *
     * @param  \App\Models\Gestion\GestionCita  $gestionCita
     * @return void
     */
    public function deleted(GestionCita $gestionCita)
    {
        //
    }

    /**
     * Handle the GestionCita "restored" event.
     *
     * @param  \App\Models\Gestion\GestionCita  $gestionCita
     * @return void
     */
    public function restored(GestionCita $gestionCita)
    {
        //
    }

    /**
     * Handle the GestionCita "force deleted" event.
     *
     * @param  \App\Models\Gestion\GestionCita  $gestionCita
     * @return void
     */
    public function forceDeleted(GestionCita $gestionCita)
    {
        //
    }
}
