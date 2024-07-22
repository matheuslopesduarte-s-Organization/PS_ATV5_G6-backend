@extends('layouts.layout')

@section('title', 'login')

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
    <form method="POST" action="{{ route('users.login.submit') }}">
        @csrf

        <div>
            <label for="email">E-mail ou usuario</label>
            <input id="email" type="text" name="identifier" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>

        <button type="submit">Login</button>
    </form>
    <a href="{{ route('users.register') }}">Registre-se</a>
</center>

@endsection