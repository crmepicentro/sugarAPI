<?php

namespace Tests\Feature;

use App\Models\Coupons\Campaigns;
use App\Models\Coupons\Coupons;
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
}
