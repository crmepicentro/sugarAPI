<?php

namespace Database\Factories;

use App\Models\Auto;
use App\Models\Propietario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Auto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $marcas = ['Etios',
            'Etios Aibo',
            'Yaris',
            'GR Yaris',
            'Corolla ',
            'Corolla GR-Sport',
            'Prius ',
            'Camry ',
            'Hilux',
            'Hilux GR-Sport',
            'Hiace Furgón',
            'Hiace Commuter',
            'Hiace Wagon',
            'C-HR ',
            'Corolla Cross ',
            'RAV4 ',
            'SW4',
            'SW4 DIAMOND',
            'SW4 GR-Sport',
            'Land Cruiser Prado',
            'Land Cruiser 300 VX',
            'Land Cruiser 300 GR-S',
        ];
        $familia =[
            'Sedan',
            'SUV',
            'Pickup',
            'Coupe',
            'Crossover',
        ];

        return [
            'propietario_id'    => Propietario::inRandomOrder()->first()->id,
            "id_ws_logs"    => $this->faker->numberBetween(0, 1000000),
            //'id_auto_s3s'       => $this->faker->uuid,
            'placa'             => Str::upper(Str::random(4).'-'.$this->faker->numberBetween(0000, 9999)) ,
            'chasis'            => Str::upper(Str::random(4).'-'.$this->faker->numberBetween(0000, 9999))  ,
            'modelo'            => Arr::random($marcas),
            'descVehiculo'           => Arr::random($familia),
            'marcaVehiculo'           => Arr::random($familia),
            'anioVehiculo'           => Arr::random($familia),
            'masterLocVehiculo'           => Arr::random($familia),
            'katashikiVehiculo'           => Arr::random($familia),
        ];
    }
}
