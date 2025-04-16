<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">    
    <title>@yield('template_title', 'GYM DRAGON')</title>
    
    <style>
        :root {
            --dragon-red: #d62828;
            --dragon-dark: #003049;
            --dragon-gold: #f77f00;
            --dragon-light: #eae2b7;
            --header-height: 70px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: var(--header-height);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }

        /* Navbar estilo Gym Dragon */
        .navbar {
            background: linear-gradient(135deg, var(--dragon-dark), var(--dragon-red));
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: 700;
            color: white;
            margin: 0 1rem;
            line-height: 1.2;
        }
        
        .logo-main {
            font-size: 1.4rem;
            letter-spacing: 1px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .logo-sub {
            font-size: 0.7rem;
            color: var(--dragon-light);
            letter-spacing: 0.5px;
        }

        .navbar-brand img {
            max-height: 40px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 0.5rem;
            position: relative;
            padding: 0.5rem 1rem !important;
        }
        
        .nav-link:before {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--dragon-gold);
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }
        
        .nav-link:hover:before {
            visibility: visible;
            width: 100%;
        }

        /* Estilos para el dropdown de usuario */
        .dropdown-menu {
            background: linear-gradient(135deg, var(--dragon-dark), var(--dragon-red));
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            overflow: hidden;
            min-width: 200px;
        }

        .dropdown-item {
            color: white !important;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            padding-left: 1.5rem;
            color: var(--dragon-gold) !important;
        }

        /* Botón de login */
        .btn-dragon {
            background-color: var(--dragon-gold);
            color: white;
            font-weight: 600;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-dragon:hover {
            background-color: #e67300;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            color: white;
        }

        /* Contenido principal */
        main.container {
            flex: 1;
            padding-top: 20px;
            padding-bottom: 40px;
            margin-top: calc(var(--header-height) + 10px);
        }

        /* Footer */
        footer {
            padding: 15px 0;
            background: linear-gradient(135deg, var(--dragon-dark), var(--dragon-red));
            color: white;
            text-align: center;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: var(--dragon-gold);
            transform: translateY(-3px);
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .logo-main {
                font-size: 1.2rem;
            }
            
            .logo-sub {
                font-size: 0.6rem;
            }
            
            .navbar-brand img {
                max-height: 35px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand py-0">
                <img src="{{ asset('images/dragonesgym.png') }}" alt="Logo GYM DRAGON" />
            </a>
            
            <div class="logo py-0">
                <span class="logo-main">GYM DRAGON</span>
                <span class="logo-sub">Valle de Bravo · Edo.Mex</span>
            </div>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2" style="font-size: 1.2rem;"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                               
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-dragon me-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Ingresar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="social-icons mb-2">
                <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-whatsapp"></i></a>
            </div>
            <small class="text-white">
                &copy; {{ date('Y') }} GYM DRAGON. Todos los derechos reservados.
            </small>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Mejorar el dropdown
            $('.dropdown').hover(function() {
                $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(200);
            }, function() {
                $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(200);
            });

            // Animación para el botón de cerrar sesión
            $('.dropdown-item[href="{{ route('logout') }}"]').hover(
                function() {
                    $(this).find('i').css('transform', 'rotate(180deg)');
                },
                function() {
                    $(this).find('i').css('transform', 'rotate(0deg)');
                }
            );
        });
    </script>
    @stack('scripts')
</body>
</html>