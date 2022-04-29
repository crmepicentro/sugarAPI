<?php

namespace Database\Factories;

use App\Models\Conductor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ConductorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conductor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id'        => Str::lower(Str::random(10).'-'.Str::random(4).'-'.Str::random(4).'-'.Str::random(5).'-'.Str::random(12)) ,
            'cedula'            => $this->faker->numberBetween(1000000000, 1800000000),
            'nombre_usuario'    => $this->faker->firstName(),
            'apellido_usuario'  => $this->faker->lastName(),
            'telefono_usuario'  => $this->faker->phoneNumber,
            'email_usuario'     => $this->faker->unique()->safeEmail(),
        ];
    }
}
