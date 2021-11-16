<?php

namespace Database\Factories\Sugar;

use App\Models\Sugar\Prospeccion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProspeccionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prospeccion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'PROSPECTO-PRUEBA',
            'nombres' => $this->faker->name,
            'apellidos' => $this->faker->lastName,
            'numero_identificacion' => $this->faker->numerify('##########'),
            'celular' => $this->faker->numerify('##########'),
            'tipo_identificacion' => 'C',
            'email' => $this->faker->unique()->safeEmail,
            'fuente' => 'tests_source',
            'description' => 'tests_source',
            'date_entered' => Carbon::now('UTC'),
            'date_modified' => Carbon::now('UTC')
        ];
    }
}
