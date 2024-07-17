<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

class LivrosController extends Controller 
{

    public function index(Request $request) 
    {
        $page = $request->input("page",1);
        $perPage = $request->input("",10);
        $livro = Livro::paginate($perPage);
        
        return view("acervo/livros", compact("page",""));

    }

    public function create()
    {
        return view("acervo/adicionar");
    }

    public function store(Request $request)
    {

    }
    

}