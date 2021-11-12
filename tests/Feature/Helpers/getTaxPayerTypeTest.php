<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getTaxPayerTypeTest extends TestCase
{
    /** @test */
    public function getTaxPayerType()
    {
       $this->assertEquals('01', getTaxPayerType('1719932079001'));
       $this->assertEquals('01', getTaxPayerType('9999999999'));
       $this->assertEquals('02', getTaxPayerType('1799999999001'));
       $this->assertEquals('03', getTaxPayerType('1769999999001'));
    }
}
