<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutoresController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input("perPage", 10);
        $autores = Autor::paginate($perPage);

        return view("acervo.autores.autores", ["autores" => $autores]);
    }

    public function create()
    {
        return view("acervo/autores/adicionar");
    }

    public function store(Request $request)
    {
        $autor = new Autor();
        $autor->nome = $request->input("nome");
        $autor->nacionalidade = $request->input("nacionalidade");
        $autor->data_nascimento = $request->input("data_nascimento");
        $autor->biografia = $request->input("biografia");
        $autor->misc = $request->input("misc");
        $autor->save();

        return redirect()->route("acervo.autores");
    }

    public function edit(Autor $autor)
    {
        return view("acervo/autores/editar", ["autor" => $autor]);
    }

    public function update(Request $request, Autor $autor)
    {
        $autor->nome = $request->input("nome");
        $autor->nacionalidade = $request->input("nacionalidade");
        $autor->data_nascimento = $request->input("data_nascimento");
        $autor->biografia = $request->input("biografia");
        $autor->misc = $request->input("misc");
        $autor->save();

        return redirect()->route("acervo.autores");
    }

    public function destroy(Autor $autor)
    {
        $autor->delete();

        return redirect()->route("acervo.autores");
    }
}