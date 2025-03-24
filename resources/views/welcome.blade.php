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

    </style>
    <title>Gym | Welcome</title>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-md bg-primary py-1">
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
                    <a href="#" class="nav-link text-light">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-light">About</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-light">Classes</a>
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

<!-- Header -->
<header class="header pt-6">
    <div class="row">
        <div class="col-md-6 text-light">
            <div class="text-container p-5">
                <h1 class="display-1 fw-bold text-capitalize">
                    Best fitness <br />
                    center for you
                </h1>
                <p class="lead py-2">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                </p>
                <button class="btn btn-primary text-uppercase py-2 px-4">Get Started</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="image-container px-4">
                <img src="{{ asset('images/showcase.png') }}" alt="" class="img-fluid" />
            </div>
        </div>
    </div>
</header>



<!-- Footer -->
<footer class="bg-primary text-center p-4 text-white">
    <p class="mb-2">
        GYM DRAGON
        <span>Valle de Bravo · Edo.Mex</span>
    </p>
    <div>
        <a href="#" class="text-white"><i class="bi bi-envelope"></i></a>
        <a href="#" class="text-white"><i class="bi bi-whatsapp"></i></a>
        <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
    </div>
    <p class="mt-2">
        <a href="#" class="text-white">Aviso de privacidad</a> ·
        <a href="#" class="text-white">Políticas de Desarrollo</a>
    </p>
    <small>2025 © Desarrollado Por CDN</small>
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
