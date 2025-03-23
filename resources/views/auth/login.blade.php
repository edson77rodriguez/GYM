<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <style>
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-weight: bold;
            color: white;
        }

        .logo span {
            font-size: 0.9rem;
            color: #f8f9fa;
        }

        .logo a img {
            width: 60px; /* Ajusta el tamaño del logo */
            margin-top: 5px;
        }

        footer {
            background-color: #f76c2a; /* Naranja */
            padding: 1rem 0; /* Reducción del tamaño */
            color: white;
            font-size: 0.875rem; /* Reducir tamaño de fuente */
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        footer p {
            margin: 0;
        }

        footer .social-icons a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
        }

        footer .social-icons a:hover {
            color: #ddd;
        }

        footer .privacy-links {
            font-size: 0.75rem; /* Fuente más pequeña */
        }

        footer .privacy-links a {
            margin: 0 5px;
            color: white;
            text-decoration: none;
        }

        footer .privacy-links a:hover {
            color: #ddd;
        }

        /* Estilos para el formulario */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f76c2a;
            color: white;
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #f76c2a;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e65d1e;
        }

        .btn-link {
            color: #f76c2a;
        }

        .btn-link:hover {
            color: #e65d1e;
        }

        .form-check-label {
            color: #555;
        }

        .form-check-input:checked {
            background-color: #f76c2a;
            border-color: #f76c2a;
        }
    </style>
    <title>Gym | Welcome</title>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-md bg-primary py-2">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="{{ asset('images/dragonesgym.png') }}" alt="Logo" />
        </a>
        <div class="logo">
            GYM DRAGON
            <span>Valle de Bravo · Edo.Mex</span>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link text-light">Home</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-info rounded-1 me-2" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-info rounded-1" href="{{ route('register') }}">Registrarse</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<p></p>

<!-- Footer -->
<footer>
    <div class="text-center mt-1">
        <p>
            GYM DRAGON
            <span>Valle de Bravo · Edo.Mex</span>
        </p>
        <div class="social-icons">
            <a href="#" class="text-white"><i class="bi bi-envelope"></i></a>
            <a href="#" class="text-white"><i class="bi bi-whatsapp"></i></a>
            <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
        </div>
        <p class="privacy-links mt-2">
            <a href="#" class="text-white">Aviso de privacidad</a> ·
            <a href="#" class="text-white">Políticas de Desarrollo</a>
        </p>
        <small>2025 © Desarrollado Por CDN</small>
    </div>
</footer>

<!-- Agregar Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"
></script>
</body>
</html>
