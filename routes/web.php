<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\KarierController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::get('/karier', [KarierController::class, 'index'])->name('karier');
Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan');

Route::get('/login', [LoginController::class, 'index'])->name('login');
