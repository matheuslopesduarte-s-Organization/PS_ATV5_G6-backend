<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/acervo/livros', 'LivrosController@index')->name('acervo.livros');

Route::get('/acervo/livros/adicionar', [LivrosController::class, 'create'])->name('acervo.livros.adicionar');

Route::post('/acervo/livros/adicionar','LivrosController@store')->name('acervo.livros.store');
Route::patch('/acervo/livros/{livro}', 'LivrosController@update')->name('acervo.livros.update');
Route::delete('/acervo/livros/{livro}', 'LivrosController@destroy')->name('acervo.livros.destroy');

