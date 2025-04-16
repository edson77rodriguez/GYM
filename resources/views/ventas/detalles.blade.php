@extends('layouts.app')

@section('template_title')
    Carrito de Compras - Agregar Detalles a la Venta
@endsection

@section('content')
<div class="container py-4">
    <!-- Encabezado mejorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-shopping-cart me-2"></i> Carrito de Compras
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Carrito</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-primary fs-6">
                Venta #{{ $venta->id_venta }}
            </span>
        </div>
    </div>

    <!-- Notificaciones mejoradas -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Formulario de Agregar Producto - Tarjeta mejorada -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Agregar Suplemento
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ventas.detalles.store', ['venta' => $venta->id_venta]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_suplemento" class="form-label fw-bold text-muted">
                                <i class="fas fa-pills me-1"></i> Suplemento
                            </label>
                            <select name="id_suplemento" id="id_suplemento" class="form-select form-select-lg" required>
                                <option value="">Seleccione un suplemento</option>
                                @foreach ($suplementos as $suplemento)
                                    <option value="{{ $suplemento->id_suplemento }}" data-precio="{{ $suplemento->precio }}">
                                        {{ $suplemento->nom_suplemento }} - ${{ number_format($suplemento->precio, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cantidad" class="form-label fw-bold text-muted">
                                    <i class="fas fa-sort-numeric-up me-1"></i> Cantidad
                                </label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control form-control-lg" required min="1" value="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-dollar-sign me-1"></i> Precio Unitario
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="text" id="precio_unitario" class="form-control form-control-lg bg-light" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-cart-plus me-2"></i> Agregar al Carrito
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Detalles del Carrito - Tabla mejorada -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-list-alt me-2"></i> Resumen del Pedido
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($venta->detallesVentas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4"><i class="fas fa-pills me-1"></i> Producto</th>
                                        <th class="text-center"><i class="fas fa-hashtag me-1"></i> Cantidad</th>
                                        <th class="text-center"><i class="fas fa-dollar-sign me-1"></i> Precio</th>
                                        <th class="text-center"><i class="fas fa-calculator me-1"></i> Subtotal</th>
                                        <th class="pe-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($venta->detallesVentas as $detalle)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <i class="fas fa-pills text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $detalle->suplemento->nom_suplemento }}</h6>
                                                        <small class="text-muted">Ref: {{ $detalle->suplemento->id_suplemento }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $detalle->cantidad }}</span>
                                            </td>
                                            <td class="text-center">
                                                ${{ number_format($detalle->suplemento->precio, 2) }}
                                            </td>
                                            <td class="text-center fw-bold">
                                                ${{ number_format($detalle->subtotal, 2) }}
                                            </td>
                                            <td class="pe-4">
                                                <form action="{{ route('ventas.detalles.destroy', ['detalle' => $detalle->id_detalle_venta]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Resumen de compra mejorado -->
                        <div class="p-4 bg-light border-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal:</span>
                                        <span class="fw-bold">${{ number_format($venta->monto, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">IVA (0%):</span>
                                        <span class="fw-bold">$0.00</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Total:</span>
                                        <span class="fw-bold fs-5 text-primary">${{ number_format($venta->monto, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end justify-content-end">
                                    <div class="d-grid gap-2 w-100">
                                        <a href="{{ route('ventas.index') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-check-circle me-2"></i> Finalizar Compra
                                        </a>
                                        <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-2"></i> Volver
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-3">Tu carrito está vacío</h5>
                            <p class="text-muted">Agrega suplementos para comenzar tu compra</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Mostrar precio cuando se selecciona un suplemento
        $('#id_suplemento').change(function() {
            const precio = $(this).find(':selected').data('precio');
            $('#precio_unitario').val(precio ? precio.toFixed(2) : '0.00');
        }).trigger('change');

        // Confirmación antes de eliminar
        $('form[method="DELETE"]').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: '¿Eliminar producto?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
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
    .table {
        margin-bottom: 0;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .table td {
        vertical-align: middle;
    }
    .form-select-lg, .form-control-lg {
        padding: 0.75rem 1rem;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0.5rem;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endsection