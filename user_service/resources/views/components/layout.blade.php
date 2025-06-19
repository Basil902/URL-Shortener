<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- import font from google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+NSW+ACT+Cursive:wght@400..700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <header class="header border-2">
        <nav class="flex flex-row justify-between">
            <a href="{{ route('home.index') }}" class="navbar-title ">URL Shortener.com</a>
            <div class="flex flex-row items-center gap-3">
                <a href="{{ route('home.index') }}" class="navbar-link">Home</a>
                @guest
                <a href="{{ route('login.show') }}" class="navbar-link">Login</a>
                <a href="{{ route('register.show') }}" class="navbar-link">Register</a>
                @endguest
                @auth
                <a href="{{ route('user.profile') }}" class="navbar-link">Profile</a>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="navbar-link">Logout</button>
                </form>
                @endauth
            </div>
        </nav>
    </header>
    <main class="w-screen">{{ $slot }}</main>
</body>
</html>