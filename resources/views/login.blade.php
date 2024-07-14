<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="/login">
        @csrf

        <div>
            <label for="email">E-mail</label>
            <input id="email" type="text" name="identifier" value="{{ old('email') }}" required autofocus>
            @error('identifier')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Login</button>
    </form>
</body>
</html>
