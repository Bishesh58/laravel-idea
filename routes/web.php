<?php

use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [LoginUserController::class, 'create'])->name('login');
    Route::post('/login', [LoginUserController::class, 'store']);
});

Route::post('/logout', [LoginUserController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
