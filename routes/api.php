<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadApiController;
use App\Http\Controllers\Api\CreditScoreController;

Route::post('/leads', [LeadApiController::class, 'store']);

// Mock Credit Score API (simulates a third-party CIBIL/Experian endpoint)
Route::post('/credit-score/check', [CreditScoreController::class, 'check']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
