<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataBasePostVentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'ws_logs2022-04-25 09-54-01.sql');
        DB::unprepared(file_get_contents($path));
        $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'pvt_propietarios2022-04-25 09-54-01.sql');
        DB::unprepared(file_get_contents($path));
        $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'pvt_autos2022-04-25 09-54-01.sql');
        DB::unprepared(file_get_contents($path));

        $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'pvt_detalle_gestion_oportunidades2022-04-25 09-54-01.sql');
        DB::unprepared(file_get_contents($path));
        $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'pvt_gestion_agendados2022-04-25 09-54-01.sql');
        DB::unprepared(file_get_contents($path));
        $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'pvt_gestion_agendado_detalle_op2022-04-25 09-54-01.sql');
        DB::unprepared(file_get_contents($path));
        $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'pvt_gestion_nuevos2022-04-25 09-54-01.sql');
        DB::unprepared(file_get_contents($path));*/
        $path = base_path('database'.DIRECTORY_SEPARATOR.'seeders'.DIRECTORY_SEPARATOR.'seed_data'.DIRECTORY_SEPARATOR.'sql_sugarcrm_20220511.sql');
        DB::unprepared(file_get_contents($path));

    }
}
