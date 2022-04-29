<?php

namespace Database\Seeders;

use App\Models\Propietario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropietarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Propietario::factory(100)->create();
    }
}
