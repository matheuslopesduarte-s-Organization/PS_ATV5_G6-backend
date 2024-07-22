<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/acervo/livros', [LivrosController::class, 'index'])->name('acervo.livros');

Route::get('/acervo/livros/adicionar', [LivrosController::class, 'create'])->name('acervo.livros.create');

Route::post('/acervo/livros/adicionar', [LivrosController::class, 'store'])->name('acervo.livros.store');
Route::patch('/acervo/livros/{livro}', [LivrosController::class, 'update'])->name('acervo.livros.update');
Route::delete('/acervo/livros/{livro}', [LivrosController::class, 'destroy'])->name('acervo.livros.destroy');

