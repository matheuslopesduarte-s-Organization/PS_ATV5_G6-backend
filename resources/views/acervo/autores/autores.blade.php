@extends('layouts.layout')

@section('content')

@if (session('user'))
    <h1>Olá, {{ session('user')['username'] }}</h1>

@endif

<h1>Autores</h1>
<a href="{{ route('acervo.autores.create') }}">Adicionar Autor</a>
@if ($autores->isEmpty())
    <p>Não existem autores registados</p>
@endif
@foreach ($autores as $autor)
    <div class="autor">
        {{ $autor->id }}
        {{ $autor->nome }}
        {{ $autor->preco }}
        <form action="{{ route('acervo.autores.destroy', $autor) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Apagar</button>
        </form>
    </div>
@endforeach

{{ $autores->links() }}


@endsection

@section('style')
    <style>
        .autor {
            display: flex;
            justify-content: space-between;
            border: 1px solid black;
            padding: 10px;
            margin: 10px;
        }
    </style>
@endsection