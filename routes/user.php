<?php

use App\Http\Controllers\User\Release\ReleaseController;
use Illuminate\Support\Facades\Route;

Route::controller(ReleaseController::class)
    ->middleware('guest:user')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/login', 'login')->name('login');
        Route::get('/register', 'register')->name('register');
        Route::get('/app', 'download')->name('app');
    });
