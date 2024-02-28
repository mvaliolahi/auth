<?php


Route::prefix('auth')->middleware(['web'])->group(function () {
    Route::redirect('/', '/auth/login', 301);;
    Route::get('/login', 'Mvaliolahi\Auth\Http\Controllers\AuthController@loginForm')->name('auth.login');
    Route::post('/logout', 'Mvaliolahi\Auth\Http\Controllers\AuthController@logout')->middleware('auth')->name('auth.logout');
    Route::post('/send-token', 'Mvaliolahi\Auth\Http\Controllers\AuthController@sendToken')->middleware('throttle:5')->name('auth.send.token');
    Route::get('/verify/{mobile}', 'Mvaliolahi\Auth\Http\Controllers\AuthController@verifyTokenForm')->name('auth.verify.form');
    Route::post('/verify-token', 'Mvaliolahi\Auth\Http\Controllers\AuthController@verify')->name('auth.verify')->middleware('throttle:5');
});
