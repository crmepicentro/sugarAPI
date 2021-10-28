<?php

namespace Tests\Feature;

use App\Models\Coupons\Campaigns;
use App\Services\PricingClass;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PricingTest extends TestCase
{

    use RefreshDatabase, WithFaker;
    protected function setUp(): void
    {
        parent::setUp();
        $this->setInitDataUserSanctum();
    }

    public function testLoginPricing()
    {
        Http::fake([
            env('PRICING').'authentication' => Http::response(['token' =>'tokenPricing'], 200)
        ]);
        $token = PricingClass::getToken();
        $this->assertEquals('tokenPricing', $token);
        Http::assertSent(function (Request $request) {
            return $request->url() == env('PRICING').'authentication' &&
                $request['user'] == env('USER_PRICING') &&
                $request['password'] == env('PASSWORD_PRICING');
        });
    }

    public function testLoginPricingError()
    {
        Http::fake([
            env('PRICING').'authentication' => Http::response(['token' =>'tokenPricing'], 500)
        ]);
        try{
            PricingClass::getToken();
        }catch (\Exception $e){
            $this->assertEquals(500, $e->getCode());
        }
    }

    public function testGetPricing()
    {
        Http::fake([
            env('PRICING').'authentication' => Http::response(['token' =>'tokenPricing'], 200),
            env('PRICING').'pricing' => Http::response(['precio_nuevo' => '15000', 'precio_toma' => '12500', 'status'=> true], 200)
        ]);
        $data = [
          'id_descripcion' => 12,
          'anio' => 2010,
          'placa' => 'PCR5214',
          'recorrido' => 53500,
          'unidad' => 'Km',
          'descuentos' => [
              ['id' => 1 , 'valor' => 50,12],
          ]
        ];
        $pricing = PricingClass::getPricing($data['id_descripcion'],$data['anio'], $data['placa'], $data['recorrido'], $data['unidad'], $data['descuentos']);
        $this->assertEquals('15000', $pricing->precio_nuevo);
        $this->assertEquals('12500', $pricing->precio_toma);
        $this->assertEquals(true, $pricing->status);
        Http::assertSent(function (Request $request) use($data) {
            return
                $request->hasHeader('Authorization', 'Bearer tokenPricing') &&
                $request->url() == env('PRICING').'pricing' &&
                $request['data']['id_descripcion'] == $data['id_descripcion'] &&
                $request['data']['anio'] == $data['anio'] &&
                $request['data']['placa'] == 'P' &&
                $request['data']['recorrido'] == $data['recorrido'] &&
                $request['data']['unidad'] == $data['unidad'] &&
                $request['data']['descuentos'] == $data['descuentos'] &&
                $request['data']['valor_nuevo'] == null;
        });
    }

    public function testGetPricingError()
    {
        Http::fake([
            env('PRICING').'authentication' => Http::response(['token' =>'tokenPricing'], 200),
            env('PRICING').'pricing' => Http::response(['precio_nuevo' => '15000', 'precio_toma' => '12500', 'status'=> true], 501)
        ]);
        $data = [
            'id_descripcion' => 12,
            'anio' => 2010,
            'placa' => 'PCR5214',
            'recorrido' => 53500,
            'unidad' => 'Km',
            'descuentos' => [
                ['id' => 1 , 'valor' => 50,12],
            ]
        ];
        try{
        PricingClass::getPricing($data['id_descripcion'],$data['anio'], $data['placa'], $data['recorrido'], $data['unidad'], $data['descuentos']);
        }catch (\Exception $e){
            $this->assertEquals(501, $e->getCode());
        }
    }

    public function testServicePricing(){
        $data = [
            'id_descripcion' => 5,
            'recorrido' => 1000,
            'placa' => 'PCR5214',
            'unidad' => 'km',
            'anio' => 2010,
            'valor_nuevo' => null,
            'descuentos' => [
                ['id' => 5 ,'valor' => 0],
                ['id' => 2,'valor' => 10],
            ]
        ];

        Http::fake([
            env('PRICING').'authentication' => Http::response(['token' =>'tokenPricing'], 200),
            env('PRICING').'pricing' => Http::response(['precio_nuevo' => '15000', 'precio_toma' => '12500', 'status'=> true], 200)
        ]);
        $response = $this->post('api/pricing',$data);
        $response->assertOk();
        $response->assertExactJson(['precio_nuevo' => '15000', 'precio_toma' => '12500', 'status'=> true]);
        Http::assertSent(function (Request $request) use($data) {
            return
                $request->hasHeader('Authorization', 'Bearer tokenPricing') &&
                $request->url() == env('PRICING').'pricing' &&
                $request['data']['id_descripcion'] == $data['id_descripcion'] &&
                $request['data']['anio'] == $data['anio'] &&
                $request['data']['placa'] == 'P' &&
                $request['data']['recorrido'] == $data['recorrido'] &&
                $request['data']['unidad'] == $data['unidad'] &&
                $request['data']['descuentos'] == $data['descuentos'] &&
                $request['data']['valor_nuevo'] == $data['valor_nuevo'];
        });
    }

    public function providerCamposNotValid(): array
    {
        return [
            'Requerido id_descripcion' => ['id_descripcion',null,"Id descripción es requerido"],
            'Requerido recorrido' => ['recorrido',null,"Recorrido es requerido"],
            'Requerido placa' => ['placa',null,"Placa es requerido"],
            'Requerido unidad' => ['unidad',null,"Unidad es requerido"],
            'Requerido anio' => ['anio',null,"Año es requerido"],
            'Requerido descuentos' => ['descuentos',null,"Descuentos es requerido"],
        ];
    }

    /**
     * @dataProvider providerCamposNotValid
     */
    public function testServicePricingErrors(string $label, $value, string $text)
    {
        $data = [
            'id_descripcion' => 5,
            'recorrido' => 1000,
            'placa' => 'PCR5214',
            'unidad' => 'km',
            'anio' => 2010,
            'valor_nuevo' => null,
            'descuentos' => [
                ['id' => 5 ,'valor' => 0],
                ['id' => 2,'valor' => 10],
            ]
        ];
        $data[$label] = $value;
        $response = $this->post('api/pricing', $data);
        $response->assertStatus(422);
        $response->assertJson(["errors" => [$label => [$text]]]);
    }
}
