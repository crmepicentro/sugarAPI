<?php

namespace Tests;

use App\Models\Api\Companies;
use App\Models\Api\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public $baseUrl = "/api/";
    public $dataTicket = [];

    public function setInitDataUser()
    {
        Companies::factory()->create();
        User::factory()->create();
    }

    public function setInitDataUserSanctum()
    {
        Companies::factory()->create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['environment:dev']
        );

        Http::fake([
            env('inconcertWS') => Http::response([
                'status' => true,
                'description' => "OK",
                'data' => [
                    "status" => "new",
                    "contactId" => "contactId"
                ]
            ], 200)
        ]);
    }

    public function setInitDataTicket()
    {
        $this->dataTicket = [
            'datosSugarCRM' => [
                'numero_identificacion' => $this->faker->numerify('##########'),
                'tipo_identificacion' => 'C',
                'email' => 'frvr@gmail.com',
                'user_name' => 'CG_RAMOS',
                'nombres' => 'FREDDY MANUEL',
                'apellidos' => 'VARGAS JACOME',
                'celular' => '0987519726',
                'telefono' => '022072826',
                'estado' => '1',
                'motivo_cierre' => 'no_contesta',
                'linea_negocio' => '2',
                'tipo_transaccion' => '1',
                'marca' => '1',
                'modelo' => '1',
                'anio' => '2020',
                'placa' => 'PCY7047',
                'kilometraje' => '190000',
                'color' => 'GRIS',
                'asunto' => 'molestias',
                'id_interaccion_inconcert' => 'id_interaccion_inconcert',
                'comentario_cliente' => 'comentario_cliente',
                'description' => 'description',
                'porcentaje_discapacidad' => '30_49',
                'medio' => 5,
                'campania' => '5e686580-ee19-11ea-97ea-000c297d72b1'
            ]
        ];
    }
}
