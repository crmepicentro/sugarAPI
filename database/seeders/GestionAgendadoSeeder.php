<?php

namespace Database\Seeders;

use App\Models\Auto;
use App\Models\DetalleGestionOportunidades;
use App\Models\GestionAgendado;
use App\Models\GestionAgendadoDetalleOportunidades;
use App\Models\GestionNuevo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class GestionAgendadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Auto::all() as $auto) {
            $valoresTomados = rand(0,$auto->detalleGestionOportunidades->count()-1);
            $a_gestionar = DetalleGestionOportunidades::where('auto_id', $auto->id)->inRandomOrder()->limit($valoresTomados)->get();
            if($a_gestionar->count()){
                $gestion = GestionAgendado::factory()->create();
                $agendasAleatorias = rand(0,5);
                foreach ($a_gestionar as $detalle) {
                    GestionAgendadoDetalleOportunidades::factory($agendasAleatorias)->create([
                        'gestion_agendado_id' => $gestion->id,
                        'detalle_gestion_oportunidad_id' => $detalle->id
                    ]);
                }
            }
        }
    }
}
