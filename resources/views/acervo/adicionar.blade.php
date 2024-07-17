<?php
    use App\Models\Autor;

    $autores = Autor::all();
?>
@extends('layouts.layout')

@section('title', 'Adicionar Livro')

@section('script')
    <script>
        function newWindow() {
            const window = document.createElement('div');
            windowid = Math.floor(Math.random() * 1000);
            window.innerHTML = `
                <h1>Adicionar autor</h1>
                <form action="{{ route('home') }}" method="POST">
                    @csrf
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome">
                    <button type="submit">Adicionar</button>
                </form>
                <button onclick="document.getElementById('${windowid}').remove()">Cancelar</button>
            `;
            window.classList.add('window');
            window.id = windowid;

            document.body.appendChild(window);
        } 

    </script>
@endsection

@section('content')

    <select name="autor" id="autor">
        <option onclick="newWindow()">Adicionar autor</option>
        @foreach($autores as $autor)
            <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
        @endforeach


@endsection