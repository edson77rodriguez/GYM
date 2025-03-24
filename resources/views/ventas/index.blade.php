@extends('layouts.app')

@section('template_title')
    Ventas
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createVentaModal">
                {{ __('Registrar Venta') }}
            </button>
        </div>

        @foreach ($ventas as $venta)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $venta->socio->nombre }} {{ $venta->socio->apellido }}</h5>
                    <p class="card-text"><strong>Fecha:</strong> {{ $venta->fecha_venta }}</p>
                    <p class="card-text"><strong>Monto:</strong> ${{ number_format($venta->monto, 2) }}</p>

                    <h6>Detalles:</h6>
                    <ul>
                        @foreach ($venta->detallesVentas as $detalle)
                            <li>{{ $detalle->suplemento->nombre }} ({{ $detalle->cantidad }} x ${{ number_format($detalle->precio, 2) }})</li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewVentaModal{{ $venta->id_venta }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editVentaModal{{ $venta->id_venta }}">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $venta->id_venta }}')">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Venta -->
        <div class="modal fade" id="viewVentaModal{{ $venta->id_venta }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles de la Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Socio:</strong> {{ $venta->socio->nombre }} {{ $venta->socio->apellido }}</p>
                        <p><strong>Fecha de Venta:</strong> {{ $venta->fecha_venta }}</p>
                        <p><strong>Monto:</strong> ${{ number_format($venta->monto, 2) }}</p>
                        <ul>
                            @foreach ($venta->detallesVentas as $detalle)
                                <li>{{ $detalle->suplemento->nombre }} ({{ $detalle->cantidad }} x ${{ number_format($detalle->precio, 2) }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Venta -->
        <div class="modal fade" id="editVentaModal{{ $venta->id_venta }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('ventas.update', $venta->id_venta) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Socio</label>
                                <select name="id_socio" class="form-select" required>
                                    @foreach ($socios as $socio)
                                        <option value="{{ $socio->id_socio }}" {{ $venta->id_socio == $socio->id_socio ? 'selected' : '' }}>
                                            {{ $socio->nombre }} {{ $socio->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha de Venta</label>
                                <input type="date" name="fecha_venta" class="form-control" value="{{ $venta->fecha_venta }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Monto</label>
                                <input type="number" name="monto" class="form-control" value="{{ $venta->monto }}" required>
                            </div>
                            <h6>Detalles:</h6>
                            <div id="detallesVenta{{ $venta->id_venta }}">
                                @foreach ($venta->detallesVentas as $detalle)
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <select name="detalles_venta[{{ $loop->index }}][id_suplemento]" class="form-select">
                                                @foreach ($suplementos as $suplemento)
                                                    <option value="{{ $suplemento->id_suplemento }}" {{ $detalle->id_suplemento == $suplemento->id_suplemento ? 'selected' : '' }}>
                                                        {{ $suplemento->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="detalles_venta[{{ $loop->index }}][cantidad]" class="form-control" value="{{ $detalle->cantidad }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="detalles_venta[{{ $loop->index }}][precio]" class="form-control" value="{{ $detalle->precio }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>

<!-- Modal Crear Venta -->
<div class="modal fade" id="createVentaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('ventas.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Socio</label>
                        <select name="id_socio" class="form-select" required>
                            @foreach ($socios as $socio)
                                <option value="{{ $socio->id_socio }}">{{ $socio->nombre }} {{ $socio->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Venta</label>
                        <input type="date" name="fecha_venta" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input type="number" name="monto" class="form-control" value="0" readonly required>
                    </div>
                    <h6>Detalles:</h6>
                    <div id="detallesVenta">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <select name="detalles_venta[0][id_suplemento]" class="form-select">
                                    @foreach ($suplementos as $suplemento)
                                        <option value="{{ $suplemento->id_suplemento }}">{{ $suplemento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="detalles_venta[0][cantidad]" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="detalles_venta[0][precio]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar Venta?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/ventas/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@if(session('success'))
    <script>Swal.fire('Éxito', '{{ session('success') }}', 'success');</script>
@endif

@endsection
