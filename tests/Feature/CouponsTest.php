<?php

namespace Tests\Feature;

use App\Models\Agencies;
use App\Models\Companies;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected function setUp(): void
    {
        parent::setUp();
        Companies::factory()->create();
        User::factory()->create();
    }

    public function testShowView()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('coupons');
        $response->assertOk();
        $response->assertViewIs('coupons.index');
        $agencies = Agencies::select('id as code','name','assigned_user_id')->where('deleted', 0)->orderBy('name')->get();
        $response->assertViewHas('agencies',json_encode($agencies));
    }
}
