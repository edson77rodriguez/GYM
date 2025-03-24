<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <title>Gym | Welcome</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .logo span {
            font-size: 0.9rem;
            color: #f8f9fa;
        }

        .logo a img {
            width: 60px; /* Adjust logo size */
            margin-top: 5px;
        }

        /* Navigation */
        .navbar {
            background-color: #ff7f00; /* Naranja */
        }

        .navbar-brand img {
            max-width: 100px;
            height: auto;
        }

        .navbar-toggler {
            background-color: #343a40;
            border: none;
            color: white;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-item .nav-link {
            color: white;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #f8f9fa;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #333;
            transition: all 0.3s;
            z-index: 999;
            padding-top: 50px;
            color: white;
        }

        #sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        #sidebar ul li {
            padding: 15px;
            text-align: left;
        }

        #sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
        }

        #sidebar ul li a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .container.sidebar-active {
            margin-left: 250px;
        }

        #sidebar.active {
            left: 0;
        }

        /* Footer */
        footer {
            padding: 20px;
            background-color: #ff7f00;
            color: white;
            text-align: center;
        }

        footer .social-icons a {
            color: white;
            margin: 0 10px;
            font-size: 1.5rem;
        }

        footer .social-icons a:hover {
            color: gray; /* Naranja */
        }

        footer .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 5px;
        }

        footer .footer-links a:hover {
            color: gray; /* Naranja */
        }

    </style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-md py-2">
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
                    <a href="#" class="nav-link">Home</a>
                </li>
       
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-info rounded-1 me-2" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-info rounded-1" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div id="sidebar">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Classes</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="container">
    @yield('content')
</div>

<!-- Footer -->
<footer>
    <p class="mb-2">
        GYM DRAGON
        <span>Valle de Bravo · Edo.Mex</span>
    </p>
    <div class="social-icons">
        <a href="#"><i class="bi bi-envelope"></i></a>
        <a href="#"><i class="bi bi-whatsapp"></i></a>
        <a href="#"><i class="bi bi-facebook"></i></a>
        <a href="#"><i class="bi bi-instagram"></i></a>
    </div>
    <p class="mt-2 footer-links">
        <a href="#">Aviso de privacidad</a> ·
        <a href="#">Políticas de Desarrollo</a>
    </p>
    <small>2025 © Desarrollado Por CDN</small>
</footer>

<!-- Bootstrap JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // Sidebar toggle functionality
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
        document.body.classList.toggle('sidebar-active');
    });
</script>
</body>
</html>
