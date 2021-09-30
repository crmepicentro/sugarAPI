<?php

namespace Tests\Feature;

use App\Models\Coupons\Campaigns;
use App\Models\Coupons\Contacts;
use App\Models\Coupons\Coupons;
use App\Models\Coupons\Mail;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponTest extends TestCase
{

    use RefreshDatabase, WithFaker;
    protected function setUp(): void
    {
        parent::setUp();
        $this->setInitDataUserSanctum();
    }

    public function testServiceValidCoupon()
    {
        $this->withoutExceptionHandling();
        $campaign = Campaigns::factory()->create(['company_id' => 1]);
        $coupons = Coupons::factory(10)->create(['campaign_id' => $campaign->id]);
        $response = $this->post('api/coupons/validate', ['code' => $coupons[0]->code]);
        $response->assertStatus(202);
        $response->assertJson(["swap" => true]);
    }

    public function providerCamposNotValid(): array
    {
        return [
            'Requerido código cupón' => ["Ingrese un código de cupón", ['code' => '']],
            'Caducado código cupón' => ["Código de cupón caducado", ['date_validity' => Carbon::now('UTC')->subDay()->toDateString()]],
            'Canjeado código cupón' => ["Código de cupón ya fue canjeado", ['status' => 2]],
            'No existe código cupón' => ["Código de cupón no existe", [], 'QWRUI421'],
        ];
    }

    /**
     * @dataProvider providerCamposNotValid
     */
    public function testPayLoadValidCouponErrors(string $text, array $valores, string $codeFake = null)
    {
        $this->withoutExceptionHandling();
        $coupon = Coupons::factory()->create($valores);
        $response = $this->post('api/coupons/validate', ['code' => $codeFake ?? $coupon->code]);
        $response->assertStatus(422);
        $response->assertJson(["errors" => ["code" => [$text]]]);
    }

    public function testCreateCoupon()
    {
        $this->withoutExceptionHandling();
        $campaign = Campaigns::factory()->create(['name'=>'Seguros','company_id'=>1,'type' => 'CUPON-INCON','id_sugar_campaign'=> null,'name_sugar_campaign'=>null]);
        $request = ['idcampana'=>$campaign->id, 'nombres' => 'Cristian Geovanny', 'apellidos' => 'Cazares Baldeon',
                    'cedula' => '1722898838', 'email' => 'ccazares@casabaca.com', 'celular' => '0984434641' ];
        $response = $this->post('api/coupons', $request);
        $response->assertCreated();
        $response->assertJson(["data" => true]);

        $contact = Contacts::where('document',$request['cedula'])->first();
        $this->assertEquals($contact->first_name, $request['nombres']);
        $this->assertEquals($contact->last_name, $request['apellidos']);
        $this->assertEquals($contact->email, $request['email']);
        $this->assertEquals($contact->mobil_phone, $request['celular']);

        $cupon = Coupons::where('campaign_id',$request['idcampana'])->where('contact_id', $contact->id)->first();
        $mail = Mail::where('campaign_id',$request['idcampana'])->where('contact_id', $contact->id)->where('coupon_id',$cupon->id)->first();
        $this->assertEquals($mail->status, 2);

        //Fake Http send mail y validar ticket inconcert
    }

    public function providerCamposNotValidCreate(): array
    {
        return [
            'Requerido idcampana' => ['idcampana',null,"Id campaña es requerido", []],
            'No existe idcampana' => ['idcampana',100,"Id campaña no existe", []],
            'Requerido cedula' => ['cedula',null,"Cédula es requerido", []],
            'Requerido nombres' => ['nombres',null,"Nombres es requerido", []],
            'Requerido apellidos' => ['apellidos',null,"Apellidos es requerido", []],
            'Requerido email' => ['email',null,"Correo Electrónico es requerido", []],
            'Requerido celular' => ['celular',null,"Celular es requerido", []],
            'Sin activar fecha campaña' => ['idcampana',null,"Campaña no válida", ['date_start' => Carbon::now('UTC')->addDay()->toDateString()]],
            'Sin activar campaña' => ['idcampana',null,"Campaña no válida", ['status' => 0]],
            'Caducado campaña' => ['idcampana',null,"Campaña no válida", ['date_end' => Carbon::now('UTC')->subDay()->toDateString()]],
            'Eliminada campaña' => ['idcampana',null,"Campaña no válida", ['deleted' => 1]],
        ];
    }

    /**
     * @dataProvider providerCamposNotValidCreate
     */
    public function testCreatePayLoadValidCouponErrors($label, $value, string $text, $valores)
    {
        $this->withoutExceptionHandling();
        $campaign = ['name'=>'Seguros','company_id'=>1,'type' => 'CUPON-INCON','id_sugar_campaign'=> null,'name_sugar_campaign'=>null];
        $campaign = Campaigns::factory()->create(array_merge($campaign,$valores));
        $request = ['idcampana'=>$campaign->id, 'nombres' => 'Cristian Geovanny', 'apellidos' => 'Cazares Baldeon',
                    'cedula' => '1722898838', 'email' => 'ccazares@casabaca.com', 'celular' => '0984434641' ];
        if($label && empty($valores)){
            $request[$label] = $value;
        }
        $response = $this->post('api/coupons', $request);
        $response->assertStatus(422);
        $response->assertJson(["errors" => [$label => [$text]]]);
    }

}
