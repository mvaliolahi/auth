<?php

use Mvaliolahi\Auth\Http\Controllers\AuthController;

Route::prefix('auth')->middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');
    Route::post('/send-token', [AuthController::class, 'sendToken'])->middleware('throttle:60,1')->name('auth.send.token');
    Route::get('/verify/{mobile}',  [AuthController::class, 'verifyTokenForm'])->name('auth.verify.form');
    Route::post('/verify-token', [AuthController::class, 'verify'])->name('auth.verify')->middleware('throttle:60,1');
});
