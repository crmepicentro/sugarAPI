<?php

namespace Database\Factories;

use App\Models\Auto;
use App\Models\Conductor;
use App\Models\ConductorAuto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
