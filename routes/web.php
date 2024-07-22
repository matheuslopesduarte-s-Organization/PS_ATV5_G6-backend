<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

Route::middleware(CheckLogin::class)->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});


use App\Jobs\EmprestimoExpire;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

Route::get('/schedule', function (Request $request) {

    $data = $request->query('delay', 0);
    $sendAt = Carbon::parse($data);


    $job = EmprestimoExpire::dispatch()->delay($sendAt);

    Log::info(get_object_vars($job->job));
    Log::info('Job created at ' . $sendAt->toDateTimeString());

    return 'Job created at ' . $sendAt->toDateTimeString();
})->name('schedule');

require __DIR__ . '/LivrosRoute.php';
require __DIR__ . '/UsersRoute.php';
require __DIR__ . '/AutoresRoute.php';