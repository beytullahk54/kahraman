<?php

use App\Events\NewMessage;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::post('/send-message', function (Request $request) {
    $message = $request->input('message');
    $username = $request->input('username');
    
    event(new NewMessage($message, $username));
    
    return response()->json(['status' => 'Message sent']);
});