<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckLogin;

use Illuminate\Support\Facades\Route;

Route::middleware(CheckLogin::class)->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});

require __DIR__ . '/LivrosRoute.php';
require __DIR__ . '/UsersRoute.php';
