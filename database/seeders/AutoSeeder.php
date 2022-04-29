<?php

namespace Database\Seeders;

use App\Models\Auto;
use App\Models\Conductor;
use Illuminate\Database\Seeder;

class AutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auto::factory(200)->create();
    }
}
