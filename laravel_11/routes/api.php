<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login rotası - auth middleware dışında olmalı
Route::post('login', [AuthController::class, 'login']);

// API rotaları için sanctum korumalı grup
Route::middleware('auth:sanctum')->group(function () {
    // Randevular için API endpoint'leri
    Route::apiResource('appointments', AppointmentController::class);
    
    // Aktivite logları için API endpoint'i
    Route::get('/activity-logs', [ActivityLogController::class, 'index']);
}); 