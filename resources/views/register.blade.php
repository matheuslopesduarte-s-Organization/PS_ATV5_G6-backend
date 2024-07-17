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


        <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name"><br>
                @error('name')
                                        <span>{{ $message }}</span>
                                @enderror
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email"><br>
                @error('email')
                                        <span>{{ $message }}</span>
                                @enderror
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password"><br>
                @error('password')
                                        <span>{{ $message }}</span>
                                @enderror
                <label for="birthdate">birthdate:</label><br>
                <input type="date" id="birthdate" name="birthdate"><br>
                @error('birthdate')
                                        <span>{{ $message }}</span>
                                @enderror
                <label for="cpf">CPF:</label><br>
                <input type="text" id="cpf" name="cpf"><br>
                @error('cpf')
                                        <span>{{ $message }}</span>
                                @enderror
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username"><br>
                @error('username')
                                        <span>{{ $message }}</span>
                                @enderror
                <button type="submit">Register</button>
        </form>
</center>
@endsection