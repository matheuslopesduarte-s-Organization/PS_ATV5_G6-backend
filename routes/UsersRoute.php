<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/login', [Auth\LoginController::class, 'create'])->name('users.login');
Route::post('/login', [Auth\LoginController::class, 'store'])->name('users.login.submit');

Route::any('/logout', [Auth\LoginController::class, 'destroy'])->name('users.logout');


Route::get('/register', [Auth\RegisterController::class, 'create'])->name('users.register');
Route::post('/register', [Auth\RegisterController::class, 'store'])->name('users.register.submit');

Route::get('/register/emailVerify', [Auth\RegisterController::class, 'emailVerify_create'])->name('users.register.emailVerify');
Route::post('/register/emailVerify', [Auth\RegisterController::class, 'emailVerify_store'])->name('users.register.emailVerify.submit');
