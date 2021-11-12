<?php

namespace Tests\Feature;

use App\Http\Middleware\UserSugarAuth;
use Illuminate\Http\Request;
use Tests\TestCase;

class MiddlewareAuthSugarTest extends TestCase
{
  public function testMiddlewareUserSugarAuth()
  {
    $request = Request::create('_test', 'GET');
    $middleware = new UserSugarAuth();
    $response = $middleware->handle($request, function () {});
    $this->assertEquals($response->getStatusCode(), 302);
  }
}
