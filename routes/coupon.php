<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponsController;
use App\Http\Middleware\UserAuth;

Route::prefix('coupons')->middleware([UserAuth::class])->group(function () {
    Route::get('/', [CouponsController::class, 'index'])->name('coupons');
});

