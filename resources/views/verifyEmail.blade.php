@extends('layouts.layout')

@section('title', 'Verificar Email')

@section('content')
<center>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>verifique seu email</p>
    <form method="POST" action="{{ route('register.emailVerify.submit') }}">
        @csrf
        <input type="text" id="codigo" name="token"><br>
        <button type="submit">Verificar</button>
    </form>
</center>
@endsection