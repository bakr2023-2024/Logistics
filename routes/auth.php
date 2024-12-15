<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest:web')->group(function () {
    Route::view('/login', 'shared.auth.login')->name('login');
    Route::view('/register', 'shared.auth.register')->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::name('password.')->group(function () {
        Route::view('/forget-password', 'shared.auth.forgot-password')->name('request');
        Route::post('/forget-password', [PasswordResetController::class, 'send'])->name('email');
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('reset');
        Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('update');
    });
});

Route::middleware('guest:admin')->prefix('admin')->group(function () {
    Route::view('login', 'shared.auth.login')->name('admin.login');
    Route::view('register', 'shared.auth.register')->name('admin.register');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('register', [AuthController::class, 'register'])->name('admin.register');

    Route::name('admin.password.')->group(function () {
        Route::view('forget-password', 'shared.auth.forgot-password')->name('request');
        Route::post('forget-password', [PasswordResetController::class, 'send'])->name('email');
        Route::get('reset-password/{token}', [PasswordResetController::class, 'reset'])->name('reset');
        Route::post('reset-password', [PasswordResetController::class, 'update'])->name('update');
    });
});

Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web');
