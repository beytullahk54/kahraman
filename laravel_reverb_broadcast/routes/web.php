<?php

use App\Events\NewMessage;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

// API Routes
Route::prefix('api')->group(function () {
    Route::post('/send-message', function (Request $request) {
        $message = $request->input('message');
        $username = $request->input('username');
        
        // Broadcast the message
        broadcast(new NewMessage($message, $username))->toOthers();
        
        return response()->json([
            'status' => 'Message sent',
            'message' => $message,
            'username' => $username
        ]);
    })->middleware('web');
});