<?php

use App\Http\Controllers\Api\v1\Allocation\AllocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Building\BuildingController;
use App\Http\Controllers\Api\v1\Dashboard\DashboardController;
use App\Http\Controllers\Api\v1\Occupant\OccupantController;
use App\Http\Controllers\Api\v1\Room\RoomController;

Route::get('/health', function () {
    return response()->json([
        'message' => 'API is healthy',
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'index']);
    
    Route::resource('/buildings', BuildingController::class);
    
    Route::resource('/rooms', RoomController::class);
    
    Route::resource('/occupants', OccupantController::class);
    
    Route::resource('/allocations', AllocationController::class);
    
    Route::post('/allocations/{allocation}/cancel', [AllocationController::class, 'cancel']);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});
