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

<!-- About -->
<section class="about py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('images/about.jpg') }}" alt="" class="img-fluid" />
            </div>
            <div class="col-md-6 py-5 ps-5">
                <p class="lead text-uppercase text-primary fw-medium">About Us</p>
                <h2 class="text-capitalize fw-bold pb-2">Welcome <br />to our gym</h2>
                <p class="text-muted">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Classes -->
<section class="classes py-6">
    <div class="container">
        <p class="lead text-uppercase text-primary fw-medium text-center">Our Classes</p>
        <h2 class="text-capitalize fw-bold pb-4 text-center text-light">Fitness classes for every goal</h2>
        <div class="row">
            <!-- Class 1 -->
            <div class="col-md-4">
                <div class="card border-0">
                    <img src="{{ asset('images/class-1.jpg') }}" alt="" class="card-img-top img-fluid" />
                    <div class="card-body px-5 py-4">
                        <div class="d-flex pb-3 gap-3">
                            <img src="{{ asset('images/icon-1.png') }}" alt="" />
                            <h5 class="card-title pt-4 fs-4 fw-medium text-capitalize">Power yoga classes</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Class 2 -->
            <div class="col-md-4 card-yoga">
                <div class="card border-0">
                    <img src="{{ asset('images/class-2.jpg') }}" alt="" class="card-img-top img-fluid" />
                    <div class="card-body px-5 py-4">
                        <div class="d-flex pb-3 gap-3">
                            <img src="{{ asset('images/icon-2.png') }}" alt="" />
                            <h5 class="card-title pt-4 fs-4 fw-medium">Weight Lifting Classes</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Class 3 -->
            <div class="col-md-4">
                <div class="card border-0">
                    <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid" />
                    <div class="card-body px-5 py-4">
                        <div class="d-flex pb-3 gap-3">
                            <img src="{{ asset('images/icon-3.png') }}" alt="" />
                            <h5 class="card-title pt-4 fs-4 fw-medium">Cardio & Strength Classes</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta py-6 text-center">
    <div class="container">
        <p class="lead text-uppercase text-primary fw-medium">Join Now</p>
        <h2 class="text-capitalize fw-bold pb-4">Get started</h2>
        <button class="btn btn-primary text-uppercase py-2 px-5">Join Now</button>
    </div>
</section>

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
