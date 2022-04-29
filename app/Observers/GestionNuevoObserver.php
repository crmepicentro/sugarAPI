<?php

namespace App\Observers;

use App\Models\GestionNuevo;

class GestionNuevoObserver
{
    /**
     * Borrar todos los elementos de GestionNuevo.
     *
     * @param  \App\Models\GestionNuevo  $gestionNuevo
     * @return void
     */
    public function BorradoGestionesAntiguas(GestionNuevo $gestionNuevo){
        $gestiones = GestionNuevo::where('detalle_gestion_oportunidad_id',$gestionNuevo->detalle_gestion_oportunidades_id)->get();
        foreach ($gestiones as $gestion) {
            $gestion->delete();
        }
    }
    /**
     * Handle the GestionNuevo "created" event.
     *
     * @param  \App\Models\GestionNuevo  $gestionNuevo
     * @return void
     */
    public function creating(GestionNuevo $gestionNuevo)
    {
        $this->BorradoGestionesAntiguas($gestionNuevo);
    }

    /**
     * Handle the GestionNuevo "updated" event.
     *
     * @param  \App\Models\GestionNuevo  $gestionNuevo
     * @return void
     */
    public function updating(GestionNuevo $gestionNuevo)
    {
        $this->BorradoGestionesAntiguas($gestionNuevo);
    }

    /**
     * Handle the GestionNuevo "deleted" event.
     *
     * @param  \App\Models\GestionNuevo  $gestionNuevo
     * @return void
     */
    public function deleted(GestionNuevo $gestionNuevo)
    {
        //
    }

    /**
     * Handle the GestionNuevo "restored" event.
     *
     * @param  \App\Models\GestionNuevo  $gestionNuevo
     * @return void
     */
    public function restored(GestionNuevo $gestionNuevo)
    {
        //
    }

    /**
     * Handle the GestionNuevo "force deleted" event.
     *
     * @param  \App\Models\GestionNuevo  $gestionNuevo
     * @return void
     */
    public function forceDeleted(GestionNuevo $gestionNuevo)
    {
        //
    }
}
