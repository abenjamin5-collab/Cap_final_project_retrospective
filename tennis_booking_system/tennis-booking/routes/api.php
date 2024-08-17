

<?php

use App\Http\Controllers\BookLessonController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::get('/coaches',[CoachController::class, 'getCoaches'])->middleware('auth:sanctum');
Route::post('/booking',[BookLessonController::class, 'store'])->middleware('auth:sanctum');