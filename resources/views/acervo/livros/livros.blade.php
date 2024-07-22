@extends('layouts.layout')

@section('title', 'Livros')

@section('content')

    <a href="{{ route('acervo.livros.create') }}">Adicionar Livro</a>

    <h1>Livros</h1>
    <p>Lista de livros</p>
    <ul>
        @foreach($livros as $livro)
            <li>{{ $livro->titulo }}</li>
        @endforeach
    </ul>
@endsection