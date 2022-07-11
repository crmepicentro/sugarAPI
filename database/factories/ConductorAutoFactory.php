<?php

namespace Database\Factories;

use App\Models\Conductor;
use App\Models\ConductorAuto;
use App\Models\Postventas\Auto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConductorAutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConductorAuto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'conductor_id'    => Conductor::inRandomOrder()->first()->id,
            'auto_id'        => Auto::inRandomOrder()->first()->id,
        ];
    }
}
