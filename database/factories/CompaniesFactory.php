<?php

namespace Database\Factories;

use App\Models\Companies;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompaniesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Companies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => 'Company Test',
            'sugar_dev' => 'sugar_dev',
            'sugar_prod' => 'sugar_dev',
            'intermedia_prod' => 'base_intermedia',
        ];
    }
}
