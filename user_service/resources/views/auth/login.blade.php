<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Login</title>
        @vite('resources/css/app.css')
    </head>
    <body
        class="animate-gradient bg-gradient-to-r from-amber-100 via-teal-300 to-sky-300 bg-[length:400%_400%]">
        <div class="flex h-screen flex-col items-center justify-center">
            <form action="{{ route('login.authenticate') }}" method="POST" class="w-225 ml-auto mr-auto flex flex-col items-center overflow-hidden p-6 font-bold absolute">
                @csrf
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="input-text-form" placeholder="example@domain.com" required />

                {{-- <div class="border-2"> --}}
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="input-text-form" required />
                <img src="{{ asset('images/eye1.png') }}" alt="show password icon" class="eyeIcon top-41.5 left-155" id="showPasswordBtn" />
                {{-- </div> --}}

                <button type="submit" class="form-btn px-47 py-4">Login</button>

                <a href="{{ route('register.show')}}" class="mt-5 text-lg font-bold">
                    No account yet? Register here
                </a>
            </form>

            @if ($errors->any())
            <div class="alert alert-danger mt-100">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="font-bold text-red-500 text-xl">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <script>
            const showPasswordBtn = document.getElementById('showPasswordBtn')
            const passwordField1 = document.getElementById('password')

            showPasswordBtn.addEventListener('click', () => {
                // decide type of password field and assign back to type attribute
                passwordField1.type = passwordField1.type === 'password' ? 'text' : 'password'
                // change eye png whenever button is clicked, based on the password field's type
                showPasswordBtn.src =
                    passwordField1.type === 'text'? "{{ asset('images/eye2.png')}}": "{{ asset('images/eye1.png')}}"
            })
        </script>
    </body>
</html>
