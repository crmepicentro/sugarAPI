<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        //\App\Models\Post::factory(5)->create();
        //\App\Models\Comment::factory(5)->create();
        /*$this->call([
            PropietarioSeeder::class,
            ConductorSeeder::class,
            AutoSeeder::class,
            ConductorAutoSeeder::class,
            DetalleGestionOportunidadesSeeder::class,
            GestionNuevoSeeder::class,
            GestionAgendadoSeeder::class,
            GestionAgendadoDetalleOportunidadesSeeder::class,
        ]);*/
        $this->call([
            DataBasePostVentasSeeder::class,
        ]);
    }
}
