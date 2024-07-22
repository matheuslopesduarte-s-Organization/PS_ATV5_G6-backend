@extends('layouts.layout')

@section('content')
    <h1>Adicionar Autor</h1>
    <form action="{{ route('acervo.autores.store') }}" method="POST">
        @csrf
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" required>
        <br>
        <label for="biografia">Biografia</label>
        <textarea name="biografia" id="biografia"></textarea>
        <br>
        <label for="data_nascimento">Data de Nascimento</label>
        <input type="date" name="data_nascimento" id="data_nascimento">
        <br>
        <label for="pais">País</label>
        <input type="text" name="pais" id="pais">
        <button type="submit">Adicionar</button>
    </form>

@endsection