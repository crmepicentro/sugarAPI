<?php

namespace Database\Factories;

use App\Models\Coupons\Contacts;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contacts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document' => $this->faker->numerify('##########'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'mobil_phone' => $this->faker->phoneNumber,
            'home_phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address
        ];
    }
}
