<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MobPanel') }} - Register</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            height: 100vh;
        }
        .form-register {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-register .form-floating:focus-within {
            z-index: 2;
        }
        .form-register input {
            margin-bottom: -1px;
            border-radius: 0;
        }
        .form-register input:first-of-type {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }
        .form-register input:last-of-type {
            margin-bottom: 10px;
            border-bottom-left-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }
    </style>
</head>
<body class="text-center">
    <main class="form-register">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="h3 mb-3 fw-normal">MobPanel</h1>
            <h2 class="h5 mb-3 fw-normal">Create an account</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required autofocus>
                <label for="name">Name</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <label for="email">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <label for="password_confirmation">Confirm Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Register</button>
            
            <div class="mt-3">
                <a href="{{ route('login') }}">Already have an account? Login</a>
            </div>
            
            <p class="mt-5 mb-3 text-muted">&copy; {{ date('Y') }} MobPanel</p>
        </form>
    </main>
</body>
</html>