<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DigitalCampaignsController;
use App\Http\Middleware\UserSugarAuth;
use App\Http\Middleware\UserAuth;

Route::prefix('campaigns')->middleware([UserAuth::class, UserSugarAuth::class])->group(function () {
    Route::get('/', [DigitalCampaignsController::class, 'index'])->name('campaigns');
    Route::post('/', [DigitalCampaignsController::class, 'store'])->name('campaign.store');
});

