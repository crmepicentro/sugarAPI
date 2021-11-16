<?php

namespace Database\Factories;

use App\Models\Api\Campaigns;
use App\Models\Coupons\Contacts;
use App\Models\Coupons\Coupons;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CouponsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupons::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => Str::upper(Str::random(9)),
            'campaign_id' => Campaigns::factory()->create(),
            'contact_id' => Contacts::factory()->create(),
            'referer' => $this->faker->uuid,
            'date_assign' => Carbon::now('UTC')->toDateString(),
            'date_validity' => Carbon::now('UTC')->addYear()->subDay()->toDateString()
        ];
    }
}
