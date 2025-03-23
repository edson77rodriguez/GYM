@extends('layouts.app')

@section('content')
    <!-- Clases -->
    <section class="classes py-6">
        <div class="container">
            <p class="lead text-uppercase text-primary fw-medium text-center">Nuestras Categorias </p>
            <h2 class="text-capitalize fw-bold pb-4 text-center text-light">Clases y Categorias de fitness para cada objetivo</h2>
            
            <div class="row">
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador' || Auth::user()->persona->rol->desc_rol == 'Empleado')
                    <div class="col-md-4">
                        <div class="card border-0 shadow-lg rounded-3">
                            <a href="{{ route('suplementos.index') }}">
                                <img src="{{ asset('images/Suplementos.jpg') }}" alt="" class="card-img-top img-fluid rounded-top" />
                            </a>
                            <div class="card-body px-5 py-4">
                                <div class="d-flex pb-3 gap-3 align-items-center">
                                    <i class="bi bi-capsule" style="font-size: 2rem; color: #ff7f00;"></i>
                                    <h5 class="card-title pt-4 fs-4 fw-medium text-capitalize text-dark">Suplementos</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador' || Auth::user()->persona->rol->desc_rol == 'Empleado')
                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                    <a href="{{ route('socios.index') }}">
                        <img src="{{ asset('images/Socios.png') }}" alt="" class="card-img-top img-fluid" />
                    </a>
                        <div class="card-body px-5 py-4">
                            <div class="d-flex align-items-center pb-3 gap-3">
                                <i class="bi bi-person-fill" style="font-size: 2rem; color: #ff7f00;"></i>
                                <h5 class="card-title pt-2 fs-4 fw-medium mb-0">Socios</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador')

                <div class="col-md-4">
                    <div class="card border-0">
                    <a href="{{ route('estado_membresias.index') }}">
                        <img src="{{ asset('images/Estados.jpg') }}" alt="" class="card-img-top img-fluid" />
                        </a>
                        <div class="card-body px-5 py-4">
                            <div class="d-flex align-items-center pb-3 gap-3">
                                <i class="bi bi-card-checklist" style="font-size: 2rem; color: #ff7f00;"></i>
                                <h5 class="card-title pt-2 fs-4 fw-medium mb-0">Estados de Membresías</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador' || Auth::user()->persona->rol->desc_rol == 'Empleado')

                <div class="col-md-4">
                    <div class="card border-0">
                    <a href="{{ route('equipos.index') }}">
                        <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid" />
                    </a>
                        <div class="card-body px-5 py-4">
                            <div class="d-flex align-items-center pb-3 gap-3">
                                <img src="{{ asset('images/icon-1.png') }}" alt="" />
                                <h5 class="card-title pt-2 fs-4 fw-medium mb-0 text-capitalize">Equipos de Gym</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador' || Auth::user()->persona->rol->desc-rol == 'Empleado')

                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                    <a href="{{ route('mantenimientos.index') }}">
                        <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid" />
                    </a>
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <i class="bi bi-tools" style="font-size: 2rem; color: #ff7f00;"></i>
                                <h5 class="card-title pt-4 fs-4 fw-medium">Mantenimiento de equipos</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador')

                <div class="col-md-4">
                    <div class="card border-0">
                    <a href="{{ route('planes.index') }}">
                        <img src="{{ asset('images/class-2.jpg') }}" alt="" class="card-img-top img-fluid" />
                    </a>
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <img src="{{ asset('images/icon-3.png') }}" alt="" />
                                <h5 class="card-title pt-4 fs-4 fw-medium">Planes</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador' || Auth::user()->persona->rol->desc_rol == 'Empleado')

                <div class="col-md-4">
                    <div class="card border-0">
                    <a href="{{ route('membresias.index') }}">
                        <img src="{{ asset('images/class-1.jpg') }}" alt="" class="card-img-top img-fluid" />
                        </a>
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <img src="{{ asset('images/icon-1.png') }}" alt="" />
                                <h5 class="card-title pt-4 fs-4 fw-medium text-capitalize">Membresías</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador' || Auth::user()->persona->rol->desc_rol == 'Empleado')

                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                        <img src="{{ asset('images/Pedidos.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <i class="bi bi-cart" style="font-size: 2rem; color: #ff7f00;"></i>
                                <h5 class="card-title pt-4 fs-4 fw-medium">Pedidos</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(Auth::check() && Auth::user()->persona->rol->desc_rol == 'Administrador' || Auth::user()->persona->rol->desc_rol == 'Empleado')

                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                        <img src="{{ asset('images/Empleados.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i>
                                <h5 class="card-title pt-4 fs-4 fw-medium">Empleados</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
