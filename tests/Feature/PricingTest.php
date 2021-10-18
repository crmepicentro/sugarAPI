<?php

namespace Tests\Feature;

use App\Helpers\Pricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PricingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPricing()
    {
        $token = Pricing::getToken();
        dd('token');
    }
}
