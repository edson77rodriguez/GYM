@extends('layouts.app')

@section('content')
    <!-- Clases -->
    <section class="classes py-6 bg-light">
        <div class="container">
            <p class="lead text-uppercase text-primary fw-medium text-center">Panel de control</p>

            <div class="row">


            @if(Auth::check() && (Auth::user()?->persona?->rol?->desc_rol == 'Administrador' ))
            <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('suplementos.index') }}">
                                <img src="{{ asset('images/Suplementos.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-capsule" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Suplementos</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('socios.index') }}">
                                <img src="{{ asset('images/Socios.png') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-person-fill" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Socios</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador')
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('estado_membresias.index') }}">
                                <img src="{{ asset('images/Estados.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-card-checklist" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Estados de Membresías</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('equipos.index') }}">
                                <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <img src="{{ asset('images/icon-1.png') }}" alt="" />
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Equipos de Gym</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('mantenimientos.index') }}">
                                <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-tools" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Mantenimiento de equipos</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador')
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('planes.index') }}">
                                <img src="{{ asset('images/class-2.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <img src="{{ asset('images/icon-3.png') }}" alt="" />
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Planes</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('membresias.index') }}">
                                <img src="{{ asset('images/class-1.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <img src="{{ asset('images/icon-1.png') }}" alt="" />
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Membresías</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('pedidos.index') }}">
                                <img src="{{ asset('images/Pedidos.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-cart" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Pedidos</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('empleados.index') }}">
                                <img src="{{ asset('images/Empleados.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-person" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Empleados</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('asistencias.index') }}">
                                <img src="{{ asset('images/asistencia.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-calendar-check" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Asistencias</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
    <div class="col-md-4 card-yoga">
        <div class="card border-0">
            <a href="{{ route('proveedores.index') }}">
                <img src="{{ asset('images/proo.jpg') }}" alt="" class="card-img-top img-fluid" />
            </a>
            <div class="card-body px-5 py-4">
                <div class="d-flex pb-3 gap-3">
                    <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i>
                    <h5 class="card-title pt-4 fs-4 fw-medium">Proveedores</h5>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
    <div class="col-md-4 card-yoga">
        <div class="card border-0">
            <a href="{{ route('ventas.index') }}">
                <img src="{{ asset('images/ventas.jpg') }}" alt="" class="card-img-top img-fluid" />
            </a>
            <div class="card-body px-5 py-4">
                <div class="d-flex pb-3 gap-3">
                    <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i>
                    <h5 class="card-title pt-4 fs-4 fw-medium">Ventas</h5>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
    <div class="col-md-4 card-yoga">
        <div class="card border-0">
            <a href="{{ route('categorias.index') }}">
                <img src="{{ asset('images/cat.jpg') }}" alt="" class="card-img-top img-fluid" />
            </a>
            <div class="card-body px-5 py-4">
                <div class="d-flex pb-3 gap-3">
                    <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i>
                    <h5 class="card-title pt-4 fs-4 fw-medium">Categorías</h5>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Administrador' ))
    <div class="col-md-4 card-yoga">
        <div class="card border-0">
            <a href="{{ route('marcas.index') }}">
                <img src="{{ asset('images/marcas.jpg') }}" alt="" class="card-img-top img-fluid" />
            </a>
            <div class="card-body px-5 py-4">
                <div class="d-flex pb-3 gap-3">
                    <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i>
                    <h5 class="card-title pt-4 fs-4 fw-medium">Marcas</h5>
                </div>
            </div>
        </div>
    </div>
@endif
@if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('GSM.index') }}">
                                <img src="{{ asset('images/Socios.png') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-person-fill" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Gestion de socios</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado' ))
                    <div class="col-md-4 card-yoga">
                        <div class="card border-0">
                            <a href="{{ route('GPM.index') }}">
                                <img src="{{ asset('images/proo.jpg') }}" alt="" class="card-img-top img-fluid" />
                            </a>
                            <div class="card-body px-5 py-4">
                                <div class="d-flex pb-3 gap-3">
                                    <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i>
                                    <h5 class="card-title pt-4 fs-4 fw-medium">Proveedores</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado' ))
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <a href="{{ route('GESP.index') }}">
                                <img src="{{ asset('images/Pedidos.jpg') }}" alt="" class="card-img-top img-fluid rounded-3"/>
                            </a>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex align-items-center pb-2 gap-2">
                                    <i class="bi bi-cart" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title fs-4 fw-bold text-dark mb-0">Pedidos</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                @if(Auth::check() && (Auth::user()->persona->rol->desc_rol == 'Empleado' ))
    <div class="col-md-4 card-yoga">
        <div class="card border-0">
            <a href="{{ route('ventas.index') }}">
                <img src="{{ asset('images/ventas.jpg') }}" alt="" class="card-img-top img-fluid" />
            </a>
            <div class="card-body px-5 py-4">
                <div class="d-flex pb-3 gap-3">
                    <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i>
                    <h5 class="card-title pt-4 fs-4 fw-medium">Gestion de Ventas</h5>
                </div>
            </div>
        </div>
    </div>
@endif

            </div>
        </div>
    </section>
@endsection
