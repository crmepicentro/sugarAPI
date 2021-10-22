<?php

namespace Tests\Feature;

use App\Services\PricingClass;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PricingTest extends TestCase
{
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
            $this->assertEquals('Error en Pricing notifique al área de BI', $e->getMessage());
        }
    }

    public function testGetPricing()
    {
        Http::fake([
            env('PRICING').'authentication' => Http::response(['token' =>'tokenPricing'], 200),
            env('PRICING').'pricing' => Http::response(['precio_nuevo' => '15000', 'precio_toma' => '12500', 'estado'=> true], 200)
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
        $this->assertEquals(true, $pricing->estado);
        Http::assertSent(function (Request $request) use($data) {
            return
                $request->hasHeader('Authorization', 'Bearer tokenPricing') &&
                $request->url() == env('PRICING').'pricing' &&
                $request['id_descripcion'] == $data['id_descripcion'] &&
                $request['anio'] == $data['anio'] &&
                $request['placa'] == 'P' &&
                $request['recorrido'] == $data['recorrido'] &&
                $request['unidad'] == $data['unidad'] &&
                $request['descuentos'] == $data['descuentos'] &&
                $request['valor_nuevo'] == null;
        });
    }

    public function testGetPricingError()
    {
        Http::fake([
            env('PRICING').'authentication' => Http::response(['token' =>'tokenPricing'], 200),
            env('PRICING').'pricing' => Http::response(['precio_nuevo' => '15000', 'precio_toma' => '12500', 'estado'=> true], 501)
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
            $this->assertEquals('Error al traer data de Pricing notifique al área de BI', $e->getMessage());
        }
    }
}
