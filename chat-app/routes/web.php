<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VersionController;
use Illuminate\Support\Facades\Route;

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

// Auth

Route::get('version/{id?}', [VersionController::class, 'index']);

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/room/{id?}', [ChatController::class, 'room']);
Route::get('/room/{room}/users', [ChatController::class, 'getRoomsUsers']);
Route::post('/room/{room}/add-user', [ChatController::class, 'getRoomAddUser']);
Route::post('/room/{room}/remove-user', [ChatController::class, 'getRoomRemoveUser']);

Route::post('/addRoom', [ChatController::class, 'addRoom']);

Route::get('/getRooms', [ChatController::class, 'getRooms']);
Route::get('/messages/{id?}', [ChatController::class, 'index']);
Route::post('/messages/{id?}', [ChatController::class, 'sendMessage']);
