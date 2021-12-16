<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use \App\Http\Middleware\EnsureUserIsValid;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->post('register', 'App\Http\Controllers\AuthController@register');
});

$api->version('v1', ['middleware' => [EnsureUserIsValid::class]], function ($api) {
   /* $api->post('register', 'App\Http\Controllers\AuthController@register');*/
    $api->post('login', 'App\Http\Controllers\AuthController@login');
    $api->post('create_landing_page', 'App\Http\Controllers\LandingPageController@store');
});

$api->version('v1', ['middleware' => [EnsureUserIsValid::class, 'auth:sanctum']], function ($api) {
    $api->get('logout', 'App\Http\Controllers\AuthController@logout');
});
//$api->post('saveForm/{token}/{name}', 'App\Http\Controllers\ActonController@store');

$api->version('v1', ['middleware' => ['api.throttle', 'auth:sanctum'], 'limit' => 200, 'expires' => 5], function ($api) {
    $api->get('history', 'App\Http\Controllers\HistoryController@index');
    $api->get('getAvaluos', 'App\Http\Controllers\AvaluosController@show');
    $api->get('getAvaluo', 'App\Http\Controllers\AvaluosController@edit');
    $api->post('createUpdateAvaluo', 'App\Http\Controllers\AvaluosController@create');
    $api->post('tickets', 'App\Http\Controllers\TicketsController@store');
    $api->post('call_ticket', 'App\Http\Controllers\TicketsController@callTicket');
    $api->post('landing_ticket', 'App\Http\Controllers\TicketsController@landingTicket');
    $api->post('not_answer_ticket/{id}', 'App\Http\Controllers\TicketsController@notAnswerTicket');
    $api->post('not_answer_call', 'App\Http\Controllers\TicketsController@notAnswerCall');
    $api->post('close_ticket/{id}', 'App\Http\Controllers\TicketsController@closeTicket');
    $api->post('ticket/addNotes/{id}', 'App\Http\Controllers\TicketsController@notesTicket');
    $api->post('calls', 'App\Http\Controllers\CallsController@store');
    $api->get('asesores', 'App\Http\Controllers\UsersController@getAsesores');
    $api->post('quotation', 'App\Http\Controllers\ProspeccionController@storeProspeccion');
    $api->post('call_quotation', 'App\Http\Controllers\ProspeccionController@storeCallProspeccion');
    $api->post('calls_prospeccion', 'App\Http\Controllers\ProspeccionController@storeCall');
    $api->post('close_prospeccion/{id}', 'App\Http\Controllers\ProspeccionController@closeProspeccion');
    $api->post('forms_prospeccion', 'App\Http\Controllers\ProspeccionController@formsProspeccion');
    $api->get('validToken', 'App\Http\Controllers\ServicesController@validToken');
    $api->get('getAgencies/{linea}', 'App\Http\Controllers\ServicesController@getAgencies');
    $api->post('pricing', 'App\Http\Controllers\ServicesController@getPricing');
    $api->post('coupons/', 'App\Http\Controllers\CouponsController@create');
    $api->put('coupons/', 'App\Http\Controllers\CouponsController@update');
    $api->post('coupons/validate', 'App\Http\Controllers\CouponsController@validateCoupon');
    $api->post('c2cOmnichannel', 'App\Http\Controllers\OmnichannelController@sendToOmnichannel');
    $api->post('sendEmail', 'App\Http\Controllers\EmailController@sendMeetingAsesor');
});

$api->version('v1', function ($api) {
    $api->get('sumate', 'App\Http\Controllers\FormsToyotaGoController@sumateForm');
    $api->get('destinos', 'App\Http\Controllers\FormsToyotaGoController@destinosForm');
    $api->get('negocios', 'App\Http\Controllers\FormsToyotaGoController@negociosForm');
});

// Accept: application/vnd.apisugarcrm.v2+json -> Agregar en los headers para llamar a la v2
/*$api->version('v2', ['middleware' => ['api.throttle', 'auth:sanctum'], 'limit' => 200, 'expires' => 5], function ($api) {
   $api->post('posts/', 'App\Http\Controllers\PostController@store');
   $api->get('posts/{id}', 'App\Http\Controllers\PostController@show');
});*/

