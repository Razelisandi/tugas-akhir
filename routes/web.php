<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\KarierController;
use App\Http\Controllers\PendidikanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::get('/karier', [KarierController::class, 'index'])->name('karier');
Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan');
