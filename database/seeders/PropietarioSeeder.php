<?php

namespace Database\Seeders;

use App\Models\Postventas\Propietario;
use Illuminate\Database\Seeder;

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
