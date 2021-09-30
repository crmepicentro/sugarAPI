<?php

use App\Http\Controllers\CarMatchController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\SugarUserBlocked;
use App\Http\Controllers\TalksController;
use App\Http\Controllers\TicketsController;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\UserSugarAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthSugarController;
use App\Http\Controllers\ErrorController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__.'/auth.php';
require __DIR__.'/campaign.php';
require __DIR__.'/services.php';

Route::middleware([UserAuth::class])->group(function () {
    Route::get('updateProspeccion', [TicketsController::class, 'updateProspeccion']);
    Route::get('login_sugar', [AuthSugarController::class, 'index'])->name('login_sugar.index');
    Route::post('login_sugar', [AuthSugarController::class, 'login'])->name('login_sugar');
    Route::get('logout_sugar', [AuthSugarController::class, 'logout'])->name('logout_sugar');
    Route::get('/error',[ErrorController::class, 'show'])->middleware([UserSugarAuth::class])->name('error');

    Route::get('/ticketsMain/{idModulo}/{idRegister}/{numeroIdentificacion}', [TicketsController::class, 'main']);
    Route::get('/ticketsHistory/{id}', [TicketsController::class, 'history']);
    Route::get('/talksHistory/{id}', [TalksController::class, 'history']);
    Route::get('/client/{numero_identificacion}', [ContactsController::class, 'client']);
    Route::get('/ticketsForms/{id}', [TicketsController::class, 'getForm']);
    Route::get('/interactionChat/{id}', [TicketsController::class, 'getChat']);
    Route::get('/carMatch/{id}', [CarMatchController::class, 'getCarMatch']);
    Route::get('/s3sCarMatch/{id}', [CarMatchController::class, 'getS3sCarMatch']);
    Route::post('sugarUserBlocked', [SugarUserBlocked::class, 'store']);
    Route::get('sugarUserBlocked', [SugarUserBlocked::class, 'index']);
    Route::get('listComercialUsers', [SugarUserBlocked::class, 'listComercialUsers']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('{any}', function () {
    return view('apidoc/index');
})->where('any', '.*');


