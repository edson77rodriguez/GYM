@extends('layouts.app')

@section('content')
    <!-- Panel de Control -->
    <section class="dashboard py-6 bg-light">
        <div class="container">
            <h2 class="text-uppercase text-primary fw-bold text-center mb-5">Panel de Control</h2>

            <div class="row g-4">
                @if(Auth::check() && (Auth::user()?->persona?->rol?->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('suplementos.index') }}">
                                <img src="{{ asset('images/Suplementos.jpg') }}" alt="Suplementos" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-capsule text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Suplementos</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('socios.index') }}">
                                <img src="{{ asset('images/Socios.png') }}" alt="Socios" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-person-fill text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Socios</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador')
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('estado_membresias.index') }}">
                                <img src="{{ asset('images/Estados.jpg') }}" alt="Estados de Membresías" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-card-checklist text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Estados de Membresías</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('equipos.index') }}">
                                <img src="{{ asset('images/class-3.jpg') }}" alt="Equipos de Gym" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-activity text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Equipos de Gym</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador') || Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('mantenimientos.index') }}">
                                <img src="{{ asset('images/class-3.jpg') }}" alt="Mantenimiento" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-tools text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Mantenimiento</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador')
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('planes.index') }}">
                                <img src="{{ asset('images/class-2.jpg') }}" alt="Planes" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-card-list text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Planes</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('membresias.index') }}">
                                <img src="{{ asset('images/class-1.jpg') }}" alt="Membresías" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-credit-card text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Membresías</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('pedidos.index') }}">
                                <img src="{{ asset('images/Pedidos.jpg') }}" alt="Pedidos" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-cart text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Pedidos</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('empleados.index') }}">
                                <img src="{{ asset('images/Empleados.jpg') }}" alt="Empleados" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-people text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Empleados</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador') || Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('asistencias.index') }}">
                                <img src="{{ asset('images/asistencia.jpg') }}" alt="Asistencias" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-calendar-check text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Asistencias</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('proveedores.index') }}">
                                <img src="{{ asset('images/proo.jpg') }}" alt="Proveedores" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-truck text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Proveedores</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('ventas.index') }}">
                                <img src="{{ asset('images/ventas.jpg') }}" alt="Ventas" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-cash-stack text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Ventas</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('categorias.index') }}">
                                <img src="{{ asset('images/cat.jpg') }}" alt="Categorías" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-tags text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Categorías</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('marcas.index') }}">
                                <img src="{{ asset('images/marcas.jpg') }}" alt="Marcas" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-shop text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Marcas</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Sección para Empleados -->
                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('GSM.index') }}">
                                <img src="{{ asset('images/Socios.png') }}" alt="Gestión de Socios" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-people-fill text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Gestión de Socios</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('GPM.index') }}">
                                <img src="{{ asset('images/proo.jpg') }}" alt="Proveedores" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-truck text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Proveedores</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('GESP.index') }}">
                                <img src="{{ asset('images/Pedidos.jpg') }}" alt="Pedidos" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-cart text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Pedidos</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado'))
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-img-container">
                            <a href="{{ route('ventas.index') }}">
                                <img src="{{ asset('images/ventas.jpg') }}" alt="Gestión de Ventas" class="card-img-top img-fluid">
                            </a>
                        </div>
                        <div class="card-body text-center p-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-cash-stack text-primary fs-3"></i>
                                <h5 class="card-title fw-bold mb-0">Gestión de Ventas</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

           
            </div>
        </div>
    </section>
@endsection

<style>
    .dashboard {
        padding: 2rem 0;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .card-img-container {
        height: 180px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    
    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .card-body {
        background-color: white;
    }
    
    .card-title {
        font-size: 1.1rem;
    }
    
    @media (max-width: 768px) {
        .card-img-container {
            height: 150px;
        }
    }
</style>