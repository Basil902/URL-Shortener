<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body class="animate-gradient bg-gradient-to-r from-amber-100 via-teal-300 to-sky-300 bg-[length:400%_400%]">
    <div class="flex h-screen items-center justify-center flex-col">
        <form action="{{ route('register.store') }}" method="POST" class="flex absolute items-center p-6 flex-col font-bold ml-auto mr-auto w-225 overflow-hidden">
            @csrf
            <label for="username" class="form-label">
                Username:
            </label>
            <input type="text" name="username" id="username" class="input-text-form" required>

            <label for="email" class="form-label">
                Email:
            </label>
            <input type="email" name="email" id="email" placeholder="example@domain.com" class="input-text-form" required>

            <label for="password" class="form-label">
                Password:
            </label>
            <input type="password" name="password" id="password" class="input-text-form" required>
            <img src="{{ asset('images/eye1.png') }}" alt="show password icon" class="eyeIcon top-64.5 left-155" id="showPasswordBtn1" />

            <label for="password_confirmation" class="form-label">
                Confirm Password:
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="input-text-form" required>
            <img src="{{ asset('images/eye1.png') }}" alt="show password icon" class="eyeIcon top-87.5 left-155" id="showPasswordBtn2" />

            <button type="submit" class="form-btn px-45 py-4">Register</button>

            <a href="{{ route('login.show') }}" class="mt-5 font-bold text-lg">Already have an account? Log in</a>

        </form>
        
        @if ($errors->any())
            <div class="alert alert-danger mt-150">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="text-red-500 font-bold text-xl">{{ $error}} </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
    <script>
        const showPasswordBtn1 = document.getElementById('showPasswordBtn1');
        const showPasswordBtn2 = document.getElementById('showPasswordBtn2');
        const passwordField1 = document.getElementById('password');
        const passwordField2 = document.getElementById('password_confirmation');

        showPasswordBtn1.addEventListener('click', () => {
            passwordField1.type = passwordField1.type === 'password'? 'text': 'password';
            showPasswordBtn1.src = passwordField1.type === "text" ? "{{ asset('images/eye2.png')}}" : "{{ asset('images/eye1.png')}}";
        });

        showPasswordBtn2.addEventListener('click', () => {
            passwordField2.type = passwordField2.type === 'password'? 'text': 'password';
            showPasswordBtn2.src = passwordField2.type === "text" ? "{{ asset('images/eye2.png')}}" : "{{ asset('images/eye1.png')}}";
        })

    </script>
</body>
</html>