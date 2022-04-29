<?php

namespace Database\Factories;

use App\Models\DetalleGestionOportunidades;
use App\Models\GestionNuevo;
use Illuminate\Database\Eloquent\Factories\Factory;

class GestionNuevoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GestionNuevo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'detalle_gestion_oportunidad_id' => DetalleGestionOportunidades::inRandomOrder()->first()->id,
            'users_id' => $this->faker->numberBetween(100, 400),
            'fecha_agendamiento' => $this->faker->dateTimeBetween('-1 days', '+1 years'),
            'observacion_agendamiento' => $this->faker->text(200),
        ];
    }
}
