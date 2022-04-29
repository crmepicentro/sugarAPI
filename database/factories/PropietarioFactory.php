<?php

namespace Database\Factories;

use App\Models\Propietario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropietarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Propietario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id'            => Str::random(10).'-'.Str::random(4).'-'.Str::random(4).'-'.Str::random(5).'-'.Str::random(12),
            'id_ws_logs'            => $this->faker->numberBetween(1000000000, 1800000000),
            'cedula'                => $this->faker->numberBetween(1000000000, 1800000000),
            'codPropietario'        => $this->faker->numberBetween(1, 1800000000),
            'nombre_propietario'    => $this->faker->name(),
            'telefono_domicilio'    => $this->faker->phoneNumber,
            'telefono_trabajo'      => $this->faker->phoneNumber,
            'telefono_celular'      => $this->faker->phoneNumber,
            'email_propietario'     => $this->faker->unique()->safeEmail(),
            'email_propietario_2'   => $this->faker->unique()->companyEmail,

        ];
    }
}
