<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\KarierController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\ChatSessionController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/chatbot', function () {
        return view('chatbot');
    })->name('chatbot');

Route::post('/chat-sessions', [ChatSessionController::class, 'create']);
Route::get('/chat-sessions/{id}/messages', [ChatSessionController::class, 'getMessages']);
Route::post('/chat-sessions/{id}/messages', [ChatSessionController::class, 'addMessage']);
Route::get('/chat-sessions', [ChatSessionController::class, 'listSessions']);
Route::put('/chat-sessions/{id}', [ChatSessionController::class, 'updateSessionName']);
Route::delete('/chat-sessions/{id}', [ChatSessionController::class, 'deleteSession']);

    Route::get('/karier', function () {
        return view('karier');
    })->name('karier');

    Route::get('/pendidikan', function () {
        return view('pendidikan');
    })->name('pendidikan');

    Route::post('/education-predict', [PendidikanController::class, 'predictEducation'])->name('education.predict');

    Route::post('/cv-upload', [CVController::class, 'upload'])->name('cv.upload');
    Route::get('/cv-manual', [CVController::class, 'manual'])->name('cv.manual');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
// Route::get('/karier', [KarierController::class, 'index'])->name('karier');
// Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan');

Route::get('/login', [LoginController::class, 'index'])->name('login');
// Route::post('/upload-cv', [CvController::class, 'upload'])->name('cv.upload');
// Route::post('/cv/save', [CVController::class, 'save'])->name('cv.save');
Route::post('/cv/save', [CVController::class, 'save'])->name('cv.save')->middleware('auth');
Route::get('/cv', [CVController::class, 'showForm'])->name('cv.form')->middleware('auth');







require __DIR__ . '/auth.php';
