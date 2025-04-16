@extends('layouts.app')

@section('template_title')
    Registrar Nueva Venta
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado mejorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-cash-register me-2"></i> Registrar Nueva Venta
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nueva Venta</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Volver a Ventas
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="fas fa-home me-2"></i> Ir a Inicio
            </a>
        </div>
    </div>

    <!-- Notificación mejorada -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tarjeta del formulario -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i> Información de la Venta
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('ventas.store') }}" method="POST" id="ventaForm">
                @csrf
                
                <div class="row">
                    <!-- Selección de Socio -->
                    <div class="col-md-6 mb-4">
                        <label for="id_socio" class="form-label fw-bold text-muted">
                            <i class="fas fa-user-tie me-1"></i> Seleccionar Socio
                        </label>
                        <select name="id_socio" id="id_socio" class="form-select form-select-lg" required>
                            <option value="">Seleccione un socio...</option>
                            @foreach ($socios as $socio)
                                <option value="{{ $socio->id_socio }}">
                                    {{ $socio->persona->nom }} {{ $socio->persona->ap }} 
                                    @if($socio->persona->am)
                                        {{ $socio->persona->am }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Seleccione el socio asociado a esta venta</small>
                    </div>

                    <!-- Fecha de Venta -->
                    <div class="col-md-6 mb-4">
                        <label for="fecha_venta" class="form-label fw-bold text-muted">
                            <i class="fas fa-calendar-day me-1"></i> Fecha de Venta
                        </label>
                        <input type="date" name="fecha_venta" id="fecha_venta" 
                               class="form-control form-control-lg" 
                               value="{{ old('fecha_venta', date('Y-m-d')) }}" 
                               required>
                        <small class="text-muted">Ingrese la fecha de realización de la venta</small>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-between border-top pt-4 mt-3">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-eraser me-2"></i> Limpiar Formulario
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Registrar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Inicializar selects con búsqueda si hay muchos socios
        if ($('#id_socio option').length > 10) {
            $('#id_socio').select2({
                placeholder: "Buscar socio...",
                allowClear: true,
                width: '100%'
            });
        }

        // Validación del formulario
        $('#ventaForm').validate({
            rules: {
                id_socio: {
                    required: true
                },
                fecha_venta: {
                    required: true,
                    date: true
                }
            },
            messages: {
                id_socio: {
                    required: "Por favor seleccione un socio"
                },
                fecha_venta: {
                    required: "Por favor ingrese la fecha de venta",
                    date: "Ingrese una fecha válida"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-4').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    .card-header {
        border-bottom: none;
    }
    .form-select-lg, .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0.5rem;
    }
    .btn-outline-primary {
        border-color: var(--bs-primary);
        color: var(--bs-primary);
    }
    .btn-outline-primary:hover {
        background-color: var(--bs-primary);
        color: white;
    }
    .select2-container--default .select2-selection--single {
        height: calc(3.5rem + 2px);
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(3.5rem + 2px);
    }
</style>
@endsection