<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckLogin;

use Illuminate\Support\Facades\Route;

Route::middleware(CheckLogin::class)->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});

Route::get('/login', function() {
    return view('login');
})->name('login');
Route::post('/login', [Auth\LoginController::class, 'login'])->name('login.submit');

Route::any('/logout', [Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', function() {
    return view('register');
})->name('register');
Route::post('/register', [Auth\RegisterController::class, 'register'])->name('register.submit');

Route::get('/register/emailVerify', function() {
    return view('verifyEmail');
})->name('register.emailVerify');
Route::post('/register/emailVerify', [Auth\RegisterController::class, 'emailVerify'])->name('register.emailVerify.submit');

require __DIR__ .'/LivrosRoute.php';