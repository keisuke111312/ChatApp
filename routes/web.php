<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

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
Route::get('/chat', [ChatController::class, 'showPusherTest']);
Route::post('send-message', [ChatController::class, 'message'])->name('chat');

Route::get('/', function () {
    return view('auth.login');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'create'])->name('home');
Route::get('/chat-history', [ChatController::class, 'index']);
// Route::post('/send-message', [ChatController::class, 'store']);
// Route::get('/chat/create', [ChatController::class, 'create'])->name('chat.create');
Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
Route::get('/chat/room/{chatRoom}', [ChatController::class, 'show'])->name('chat.show');
Route::post('/chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');