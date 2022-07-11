<?php

namespace Database\Factories;

use App\Models\Postventas\DetalleGestionOportunidades;
use App\Models\Postventas\GestionAgendado;
use App\Models\Postventas\GestionAgendadoDetalleOportunidades;
use Illuminate\Database\Eloquent\Factories\Factory;

class GestionAgendadoDetalleOportunidadesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GestionAgendadoDetalleOportunidades::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'detalle_gestion_oportunidad_id' => DetalleGestionOportunidades::inRandomOrder()->first()->id,
            'gestion_agendado_id' => GestionAgendado::factory()->create()->id,
            'estado_s3s' => GestionAgendadoDetalleOportunidades::$ESTADO_INICIAL_S3S,
            'activo' => GestionAgendadoDetalleOportunidades::$ESTADO_ACTIVO,
        ];
    }
}
