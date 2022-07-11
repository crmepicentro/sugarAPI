<?php

namespace Database\Factories;

use App\Models\Postventas\GestionAgendado;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GestionAgendadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GestionAgendado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'users_id' => $this->faker->numberBetween(100, 400),
            'codigo_seguimiento' => Str::uuid(),
        ];
    }
}
