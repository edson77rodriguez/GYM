@extends('layouts.app')

@section('template_title')
    Agregar Detalles a la Venta
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-4">Agregar Detalles a la Venta</h2>

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
            <label for="id_suplemento" class="form-label">Suplemento</label>
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
            <button type="submit" class="btn btn-dark">Agregar Detalle</button>
        </div>
    </form>

    <hr>

    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver a la lista de ventas</a>
</div>
@endsection
