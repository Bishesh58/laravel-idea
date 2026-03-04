<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('ideas.index');
    }

    return view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [LoginUserController::class, 'create'])->name('login');
    Route::post('/login', [LoginUserController::class, 'store']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginUserController::class, 'destroy'])->name('logout');
    Route::resource('ideas', IdeaController::class);
});
