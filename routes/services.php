<?php

use App\Http\Middleware\UserAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserSugarAuth;
use \App\Http\Controllers\ServicesController;

Route::prefix('services')->middleware([UserAuth::class, UserSugarAuth::class])->group(function () {
  Route::get('/getDocument', [ServicesController::class, 'getDocument'])->name('getDocument');
  Route::get('/getBussiness', [ServicesController::class, 'getBussiness'])->name('getBussiness');
  Route::get('/getAdvisers', [ServicesController::class, 'getAdvisers'])->name('getAdvisers');
});
