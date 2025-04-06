<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Gimnasio Dragon en Valle de Bravo - Transforma tu cuerpo, fortalece tu mente">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <!-- Agregar Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        :root {
            --dragon-red: #d62828;
            --dragon-dark: #003049;
            --dragon-gold: #f77f00;
            --dragon-light: #eae2b7;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        /* Navbar estilizada */
        .navbar {
            background: linear-gradient(135deg, var(--dragon-dark), var(--dragon-red));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 0;
        }
        
        .navbar-brand img {
            height: 60px;
            transition: transform 0.3s;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: 700;
            color: white;
            margin: 0 1rem;
        }
        
        .logo-main {
            font-size: 1.5rem;
            letter-spacing: 1px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .logo-sub {
            font-size: 0.8rem;
            color: var(--dragon-light);
            letter-spacing: 0.5px;
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
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('{{ asset("images/gym-background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 8rem 0 6rem;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }
        
        .hero-content {
            max-width: 600px;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .hero-btn {
            background-color: var(--dragon-red);
            font-size: 1.1rem;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .hero-btn:hover {
            background-color: #c82323;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .hero-image {
            animation: float 3s ease-in-out infinite;
            max-width: 100%;
            height: auto;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        /* Features Section */
        .features {
            padding: 6rem 0;
            background-color: #f8f9fa;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dragon-dark);
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 60%;
            height: 4px;
            background: var(--dragon-red);
            bottom: -10px;
            left: 0;
            border-radius: 2px;
        }
        
        .feature-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            height: 100%;
            border-bottom: 4px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-bottom-color: var(--dragon-gold);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--dragon-red);
            margin-bottom: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dragon-dark);
        }
        
        /* Testimonials */
        .testimonials {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--dragon-dark), #1a2a3a);
            color: white;
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 2rem;
            margin: 1rem;
            transition: all 0.3s;
        }
        
        .testimonial-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 1.5rem;
        }
        
        .testimonial-author {
            font-weight: 600;
            color: var(--dragon-gold);
        }
        
        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(rgba(214, 40, 40, 0.9), rgba(214, 40, 40, 0.9)), 
                        url('{{ asset("images/cta-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .cta-btn {
            background-color: var(--dragon-dark);
            color: white;
            font-size: 1.1rem;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }
        
        .cta-btn:hover {
            background-color: #002538;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--dragon-dark), #001524);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }
        
        .footer-logo span {
            color: var(--dragon-gold);
        }
        
        .footer-links h5 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .footer-links h5:after {
            content: '';
            position: absolute;
            width: 40%;
            height: 2px;
            background: var(--dragon-gold);
            bottom: -8px;
            left: 0;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--dragon-gold);
            padding-left: 5px;
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
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            font-size: 0.9rem;
            color: #adb5bd;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero {
                text-align: center;
                padding: 6rem 0 4rem;
            }
            
            .hero-content {
                margin-bottom: 3rem;
            }
            
            .hero-title {
                font-size: 2.3rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
    <title>Gym Dragon | Valle de Bravo - Transforma tu cuerpo</title>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="{{ asset('images/dragonesgym.png') }}" alt="Gym Dragon Logo" />
        </a>
        
        <div class="logo">
            <span class="logo-main">GYM DRAGON</span>
            <span class="logo-sub">Valle de Bravo · Estado de México</span>
        </div>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div id="navbarNav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a href="#" class="nav-link active">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="#servicios" class="nav-link">Servicios</a>
                </li>
                <li class="nav-item">
                    <a href="#testimonios" class="nav-link">Testimonios</a>
                </li>
                <li class="nav-item">
                    <a href="#contacto" class="nav-link">Contacto</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-dragon me-2" href="{{ route('login') }}">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light rounded-pill" href="{{ route('register') }}">Regístrate</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">Transforma tu cuerpo <br>y fortalece tu mente</h1>
                    <p class="hero-subtitle">En Gym Dragon te ayudamos a alcanzar tus metas con entrenamiento personalizado y equipos de última generación.</p>
                    <a href="{{ route('register') }}" class="btn hero-btn">Empieza hoy</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/showcase.png') }}" alt="Entrenamiento en Gym Dragon" class="hero-image img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features" id="servicios">
    <div class="container">
        <h2 class="section-title text-center">Nuestros Servicios</h2>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-activity"></i>
                    </div>
                    <h3 class="feature-title">Entrenamiento Personalizado</h3>
                    <p>Programas diseñados específicamente para tus objetivos, con seguimiento constante de nuestros entrenadores certificados.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h3 class="feature-title">Clases Grupales</h3>
                    <p>Desde spinning hasta crossfit, nuestras clases grupales te mantendrán motivado y te ayudarán a superar tus límites.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-nutrition"></i>
                    </div>
                    <h3 class="feature-title">Asesoría Nutricional</h3>
                    <p>Planes alimenticios personalizados para complementar tu entrenamiento y maximizar tus resultados.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="feature-title">Área de Pesas</h3>
                    <p>Equipos modernos y espacios amplios para que desarrolles tu fuerza y resistencia.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-droplet"></i>
                    </div>
                    <h3 class="feature-title">Spa y Relajación</h3>
                    <p>Área de hidromasaje y sauna para que recuperes tus músculos después del entrenamiento.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h3 class="feature-title">Programas Especiales</h3>
                    <p>Para adultos mayores, adolescentes y rehabilitación física con supervisión profesional.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials" id="testimonios">
    <div class="container">
        <h2 class="section-title text-center text-white">Lo que dicen nuestros miembros</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"En solo 3 meses en Gym Dragon he logrado transformar mi cuerpo más que en 2 años en otros gimnasios. Los entrenadores son excepcionales!"</p>
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Juan Pérez" class="rounded-circle me-3" width="50">
                        <div>
                            <p class="testimonial-author mb-0">Juan Pérez</p>
                            <small>Miembro desde 2023</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"El ambiente en Gym Dragon es increíble. Todos son muy amables y profesionales. He recuperado mi movilidad después de una lesión gracias a ellos."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="María González" class="rounded-circle me-3" width="50">
                        <div>
                            <p class="testimonial-author mb-0">María González</p>
                            <small>Miembro desde 2022</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Las instalaciones son de primera y siempre limpias. Lo mejor es la variedad de clases que ofrecen, nunca me aburro!"</p>
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Carlos Ruiz" class="rounded-circle me-3" width="50">
                        <div>
                            <p class="testimonial-author mb-0">Carlos Ruiz</p>
                            <small>Miembro desde 2024</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">¿Listo para transformar tu vida?</h2>
        <p class="lead mb-4">Únete a la familia Dragon hoy mismo y obtén un 20% de descuento en tu primer mes</p>
        <a href="{{ route('register') }}" class="btn cta-btn">Empieza ahora</a>
    </div>
</section>

<!-- Footer -->
<footer class="footer" id="contacto">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h3 class="footer-logo">GYM <span>DRAGON</span></h3>
                <p>El gimnasio más completo de Valle de Bravo, comprometido con tu salud y bienestar.</p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="footer-links">
                    <h5>Enlaces</h5>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#testimonios">Testimonios</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="footer-links">
                    <h5>Horarios</h5>
                    <ul>
                        <li>Lunes a Viernes: 6am - 10pm</li>
                        <li>Sábados: 8am - 8pm</li>
                        <li>Domingos: 9am - 4pm</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="footer-links">
                    <h5>Contacto</h5>
                    <ul>
                        <li><i class="bi bi-geo-alt me-2"></i> Av. Independencia 123, Valle de Bravo</li>
                        <li><i class="bi bi-telephone me-2"></i> (726) 123 4567</li>
                        <li><i class="bi bi-envelope me-2"></i> info@gymdragon.com</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="copyright text-center">
            <p class="mb-2">
                <a href="#" class="text-white me-3">Aviso de privacidad</a>
                <a href="#" class="text-white">Términos y condiciones</a>
            </p>
            <small>2025 © Gym Dragon - Desarrollado por CDN</small>
        </div>
    </div>
</footer>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"
></script>
</body>
</html>