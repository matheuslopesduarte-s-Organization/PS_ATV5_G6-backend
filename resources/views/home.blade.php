<!-- resources/views/main.blade.php -->
 
@extends('layouts.layout')

@section('title', 'Welcome')

@section('content')
    <?php 
    $session = session('user');

    if ($session) {
        echo "<h1>Welcome, " . $session['username'] . "</h1>";
        echo "<a href='/logout'>Logout</a>";
    } else {
        echo "<a href='/login'>Login</a>";
    }
    ?>
@endsection