@extends('layouts.app')

@section('content')
    <!-- Clases -->
    <section class="classes py-6">
        <div class="container">
            <p class="lead text-uppercase text-primary fw-medium text-center">Nuestras Categorias </p>
            <h2 class="text-capitalize fw-bold pb-4 text-center text-light">Clases  y Categorias de fitness para cada objetivo</h2>
            <div class="row">
                <!-- Clase 1 Suplementos  -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-lg rounded-3">
                        <!-- Envolvemos la imagen en un enlace que redirige a /suplementos -->
                        <a href="{{ url('/suplementos') }}">
                            <img src="{{ asset('images/class-1.jpg') }}" alt="" class="card-img-top img-fluid rounded-top" />
                        </a>
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3 align-items-center">
                                <!-- Icono de medicina o suplementos con color naranja -->
                                <i class="bi bi-capsule" style="font-size: 2rem; color: #ff7f00;"></i> <!-- Ícono de cápsula -->
                                <h5 class="card-title pt-4 fs-4 fw-medium text-capitalize text-dark">Suplementos</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clase 2 socios  -->
                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-2.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex align-items-center pb-3 gap-3">
                                <!-- Icono de persona para socios -->
                                <i class="bi bi-person-fill" style="font-size: 2rem; color: #ff7f00;"></i> <!-- Ícono de persona -->
                                <h5 class="card-title pt-2 fs-4 fw-medium mb-0">Socios</h5>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Clase 3 estados de membresia -->
                <div class="col-md-4">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex align-items-center pb-3 gap-3">
                                <!-- Icono para estados de membresías -->
                                <i class="bi bi-card-checklist" style="font-size: 2rem; color: #ff7f00;"></i> <!-- Ícono de tarjeta de membresía -->
                                <h5 class="card-title pt-2 fs-4 fw-medium mb-0">Estados de Membresías</h5>
                            </div>
                        </div>
                    </div>
                </div>        </div>
        <div class="container mt-3">

            <div class="row">
                <!-- Clase 1 Equipos de Gym-->
                <div class="col-md-4">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex align-items-center pb-3 gap-3">
                                <!-- Icono de pesa -->
                                <img src="{{ asset('images/icon-1.png') }}" alt="" /> <!-- Ícono de barbell (pesa) -->
                                <h5 class="card-title pt-2 fs-4 fw-medium mb-0 text-capitalize">Equipos de Gym</h5>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Clase 2 Mantenimiento -->
                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-3.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <!-- Icono para mantenimiento de equipos -->
                                <i class="bi bi-tools" style="font-size: 2rem; color: #ff7f00;"></i> <!-- Ícono de herramientas para mantenimiento -->
                                <h5 class="card-title pt-4 fs-4 fw-medium">Mantenimiento de equipos</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clase 3 -->
                <div class="col-md-4">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-2.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <img src="{{ asset('images/icon-3.png') }}" alt="" />
                                <h5 class="card-title pt-4 fs-4 fw-medium">Planes</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-3">
            <div class="row">
                <!-- Clase 1 -->
                <div class="col-md-4">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-1.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <img src="{{ asset('images/icon-1.png') }}" alt="" />
                                <h5 class="card-title pt-4 fs-4 fw-medium text-capitalize">Membresias</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Clase 2 -->
                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-2.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <!-- Icono para pedidos -->
                                <i class="bi bi-cart" style="font-size: 2rem; color: #ff7f00;"></i> <!-- Ícono de carrito de compras para pedidos -->
                                <h5 class="card-title pt-4 fs-4 fw-medium">Pedidos</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- empleados-->
                <div class="col-md-4 card-yoga">
                    <div class="card border-0">
                        <img src="{{ asset('images/class-2.jpg') }}" alt="" class="card-img-top img-fluid" />
                        <div class="card-body px-5 py-4">
                            <div class="d-flex pb-3 gap-3">
                                <!-- Icono para empleados -->
                                <i class="bi bi-person" style="font-size: 2rem; color: #ff7f00;"></i> <!-- Ícono de persona para empleados -->
                                <h5 class="card-title pt-4 fs-4 fw-medium">Empleados</h5>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

    </section>

@endsection
