@extends('layouts.app')

@section('template_title')
    Carrito de Compras - Agregar Detalles a la Venta
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-4">Carrito de Compras</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('ventas.detalles.store', ['venta' => $venta->id_venta]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_suplemento" class="form-label">Selecciona un Suplemento</label>
            <select name="id_suplemento" id="id_suplemento" class="form-select" required>
                <option value="">Selecciona un suplemento</option>
                @foreach ($suplementos as $suplemento)
                    <option value="{{ $suplemento->id_suplemento }}">{{ $suplemento->nom_suplemento }} - ${{ $suplemento->precio }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1">
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-dark">Agregar al Carrito</button>
        </div>
    </form>

    <hr>

    <h3 class="fw-bold text-center mb-4">Detalles del Carrito</h3>

    @if($venta->detallesVentas->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Suplemento</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detallesVentas as $detalle)
                <tr>
                    <td>{{ $detalle->suplemento->nom_suplemento }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ $detalle->subtotal }}</td>
                    <td>
                        <!-- Eliminar un suplemento del carrito -->
                        <form action="{{ route('ventas.detalles.destroy', ['detalle' => $detalle->id_detalle_venta]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <h4>Total: ${{ number_format($venta->monto, 2) }}</h4>
        <a href="{{ route('ventas.index') }}" class="btn btn-success">Confirmar Compra</a>
    </div>
    @else
        <p class="text-center">Tu carrito está vacío. Agrega suplementos para continuar.</p>
    @endif

    <hr>

    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver a la lista de ventas</a>
</div>
@endsection
