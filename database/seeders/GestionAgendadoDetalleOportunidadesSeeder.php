<?php

namespace Database\Seeders;

use App\Models\Postventas\Auto;
use App\Models\Postventas\DetalleGestionOportunidades;
use App\Models\Postventas\GestionAgendado;
use App\Models\Postventas\GestionAgendadoDetalleOportunidades;
use Illuminate\Database\Seeder;

class GestionAgendadoDetalleOportunidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Auto::inRandomOrder()->limit(1)->get() as $auto) {
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
