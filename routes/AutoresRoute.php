<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/acervo/autores', [AutoresController::class, 'index'])->name('acervo.autores');

Route::get('/acervo/autores/adicionar', [AutoresController::class, 'create'])->name('acervo.autores.create');

Route::post('/acervo/autores/adicionar', [AutoresController::class, 'store'])->name('acervo.autores.store');
Route::patch('/acervo/autores/{autor}', [AutoresController::class, 'update'])->name('acervo.autores.update');
Route::delete('/acervo/autores/{autor}', [AutoresController::class, 'destroy'])->name('acervo.autores.destroy');

