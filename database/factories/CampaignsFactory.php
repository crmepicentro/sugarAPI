<?php

namespace Database\Factories;

use App\Models\Companies;
use App\Models\Coupons\Campaigns;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaigns::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'TSN',
            'date_start' => Carbon::now('UTC')->toDateString(),
            'date_end' => Carbon::now('UTC')->addYear()->subDay()->toDateString(),
            'id_sugar_campaign' => $this->faker->uuid,
            'name_sugar_campaign' => 'TSN_Sugar',
            'type' => 'CUPON',
            'company_id' => Companies::factory()->create(),
        ];
    }
}
