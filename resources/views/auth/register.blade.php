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
        /* Los estilos siguen igual... */
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
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Campo Nombre -->
                        <div class="row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autofocus>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Apellido Paterno -->
                        <div class="row mb-3">
                            <label for="ap" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>
                            <div class="col-md-6">
                                <input id="ap" type="text" class="form-control @error('ap') is-invalid @enderror" name="ap" value="{{ old('ap') }}" required>
                                @error('ap')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Apellido Materno -->
                        <div class="row mb-3">
                            <label for="am" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>
                            <div class="col-md-6">
                                <input id="am" type="text" class="form-control @error('am') is-invalid @enderror" name="am" value="{{ old('am') }}" required>
                                @error('am')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Teléfono -->
                        <div class="row mb-3">
                            <label for="telefono" class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>
                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required>
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Correo -->
                        <div class="row mb-3">
                            <label for="correo" class="col-md-4 col-form-label text-md-end">{{ __('Correo') }}</label>
                            <div class="col-md-6">
                                <input id="correo" type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ old('correo') }}" required>
                                @error('correo')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Confirmar Contraseña -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Campo de selección de rol -->
                        <div class="row mb-3">
                            <label for="desc_rol" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>
                            <div class="col-md-6">
                                <select id="desc_rol" class="form-control @error('desc_rol') is-invalid @enderror" name="desc_rol" required>
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($roles as $rol)
                                        @if ($rol->desc_rol != 'Administrador') <!-- Excluir Administrador -->
                                            <option value="{{ $rol->desc_rol }}">{{ $rol->desc_rol }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('desc_rol')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botón de registro -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<footer>
    <div class="text-center">
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
