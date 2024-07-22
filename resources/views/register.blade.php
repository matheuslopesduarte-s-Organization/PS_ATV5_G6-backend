@extends('layouts.layout')

@section('title', 'Welcome')

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

    <form method="POST" action="{{ route('users.register.submit') }}">
        @csrf
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}"><br>
    
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="birthdate">birthdate:</label><br>
        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"><br>

        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}"><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="{{ old('username') }}"><br>

        <button type="submit">Register</button>
    </form>
</center>

@endsection