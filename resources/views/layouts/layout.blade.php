<!-- resources/views/layouts/layout.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document')</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="MenuDiv">
                <button class="menu-button">
                    <span class="menu-icon material-symbols-outlined">menu</span>
                </button>
                <RouterLink to="/" class="menu-home">
                    <span class="menu-home-span">home</span>
                </RouterLink>
            </div>

            <form class="search-bar" @submit.prevent="search" ref="search_form">
                <input type="text" class="search-input" ref="search_input" v-model="search_text" @focus="openSearch" @blur="closeSearch" placeholder="Pesquisar" />
                <button type="submit" class="menu-button search-bar-button" ref="search_button">
                    <span class="menu-icon search-icon material-symbols-outlined">search</span>
                </button>
                <div ref="search_preview" class="search-preview">
                </div>
            </form>

            <div class="user-menu">
                @if (session('user'))
                    <img class="UserPicture" src="data:image/png;base64, {{ session('user')['image'] }}" alt="Avatar" class="avatar">
                @endif
            </div>
        </nav>
    </header>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>