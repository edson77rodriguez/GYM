@extends('layouts.app')

@section('template_title')
    Crear Venta
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-4">Registrar Venta</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-secondary" onclick="window.location.href='{{ route('ventas.index') }}'">
                {{ __(' Regresar a ventas') }}
            </button>
        </div>
    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_socio" class="form-label">Socio</label>
            <select name="id_socio" id="id_socio" class="form-select" required>
                <option value="">Selecciona un socio</option>
                @foreach ($socios as $socio)
                    <option value="{{ $socio->id_socio }}">{{ $socio->persona->nom }} {{ $socio->persona->ap }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_venta" class="form-label">Fecha de Venta</label>
            <input type="date" name="fecha_venta" id="fecha_venta" class="form-control" required>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-dark">Registrar Venta</button>
        </div>
    </form>
</div>
@endsection
