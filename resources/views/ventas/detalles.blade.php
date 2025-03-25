@extends('layouts.app')

@section('template_title')
    Carrito de Compras - Agregar Detalles a la Venta
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-4">
        <i class="bi bi-cart-fill"></i> Carrito de Compras
    </h2>

    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Formulario de Agregar Producto -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <i class="bi bi-plus-circle"></i> Agregar Suplemento al Carrito
        </div>
        <div class="card-body">
            <form action="{{ route('ventas.detalles.store', ['venta' => $venta->id_venta]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="id_suplemento" class="form-label fw-bold">
                        <i class="bi bi-box-seam"></i> Selecciona un Suplemento
                    </label>
                    <select name="id_suplemento" id="id_suplemento" class="form-select" required>
                        <option value="">Seleccione un suplemento</option>
                        @foreach ($suplementos as $suplemento)
                            <option value="{{ $suplemento->id_suplemento }}">
                                {{ $suplemento->nom_suplemento }} - ${{ number_format($suplemento->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label fw-bold">
                        <i class="bi bi-sort-numeric-up"></i> Cantidad
                    </label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-cart-plus"></i> Agregar al Carrito
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <!-- Detalles del Carrito -->
    <h3 class="fw-bold text-center mb-4">
        <i class="bi bi-basket"></i> Detalles del Carrito
    </h3>

    @if($venta->detallesVentas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th><i class="bi bi-box"></i> Suplemento</th>
                        <th><i class="bi bi-tag"></i> Cantidad</th>
                        <th><i class="bi bi-cash-coin"></i> Subtotal</th>
                        <th><i class="bi bi-gear"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detallesVentas as $detalle)
                        <tr>
                            <td>{{ $detalle->suplemento->nom_suplemento }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $detalle->cantidad }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">${{ number_format($detalle->subtotal, 2) }}</span>
                            </td>
                            <td>
                                <!-- Botón para eliminar -->
                                <form action="{{ route('ventas.detalles.destroy', ['detalle' => $detalle->id_detalle_venta]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded shadow-sm">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-receipt-cutoff"></i> Total: ${{ number_format($venta->monto, 2) }}
            </h4>
            <a href="{{ route('ventas.index') }}" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Confirmar Compra
            </a>
        </div>
    @else
        <p class="text-center text-muted">
            <i class="bi bi-cart-x"></i> Tu carrito está vacío. Agrega suplementos para continuar.
        </p>
    @endif

    <hr>

    <div class="text-center">
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a la lista de ventas
        </a>
    </div>
</div>
@endsection
