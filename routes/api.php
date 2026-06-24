<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Building\BuildingController;

Route::get('/health', function () {
    return response()->json([
        'message' => 'API is healthy',
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('/buildings', BuildingController::class);
});
