@extends('layouts.app')

@section('template_title')
    Pedidos
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createPedidoModal">
                {{ __('Agregar Nuevo Pedido') }}
            </button>
        </div>
        @foreach ($pedidos as $pedido)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">Pedido #{{ $pedido->id }}</h5>
                    <p class="card-text"><strong>Proveedor:</strong> {{ $pedido->proveedor->nombre }} {{ $pedido->proveedor->apellido }}</p>

                    <p class="card-text"><strong>Suplemento:</strong> {{ $pedido->suplemento->nom_suplemento }}</p>
                    <p class="card-text"><strong>Cantidad:</strong> {{ $pedido->cantidad }}</p>
                    <p class="card-text"><strong>Fecha:</strong> {{ $pedido->fecha_pedido }}</p>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewPedidoModal{{ $pedido->id_pedido }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPedidoModal{{ $pedido->id_pedido }}">Editar</button>
                        <form onsubmit="event.preventDefault(); confirmDelete({{ $pedido->id_pedido }});" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Pedido -->
        <div class="modal fade" id="viewPedidoModal{{ $pedido->id_pedido }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $pedido->id_pedido }}</p>
                        <p><strong>Proveedor:</strong> {{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }} {{ $pedido->proveedor->persona->am }}</p>
                        <p><strong>Suplemento:</strong> {{ $pedido->suplemento->nom_suplemento }}</p>
                        <p><strong>Cantidad:</strong> {{ $pedido->cantidad }}</p>
                        <p><strong>Fecha Pedido:</strong> {{ $pedido->fecha_pedido }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Pedido -->
        <div class="modal fade" id="editPedidoModal{{ $pedido->id_pedido }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('pedidos.update', $pedido->id_pedido) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Proveedor</label>
                                <select name="id_proveedor" class="form-select" required>
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id_proveedor }}" {{ $pedido->id_proveedor == $proveedor->id_proveedor ? 'selected' : '' }}>{{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }} {{ $pedido->proveedor->persona->am }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Suplemento</label>
                                <select name="id_suplemento" class="form-select" required>
                                    @foreach ($suplementos as $suplemento)
                                        <option value="{{ $suplemento->id_suplemento }}" {{ $pedido->id_suplemento == $suplemento->id_suplemento ? 'selected' : '' }}>{{ $suplemento->nom_suplemento }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" value="{{ $pedido->cantidad }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha del Pedido</label>
                                <input type="date" name="fecha_pedido" value="{{ $pedido->fecha_pedido }}" class="form-control" required>
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

<!-- Modal Crear Pedido -->
<div class="modal fade" id="createPedidoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('pedidos.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Proveedor</label>
                        <select name="id_proveedor" class="form-select" required>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->persona->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Suplemento</label>
                        <select name="id_suplemento" class="form-select" required>
                            @foreach ($suplementos as $suplemento)
                                <option value="{{ $suplemento->id_suplemento }}">{{ $suplemento->nom_suplemento }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha del Pedido</label>
                        <input type="date" name="fecha_pedido" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id_pedido) {
        Swal.fire({
            title: '¿Eliminar Pedido?',
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
                form.action = '/pedidos/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('register'))
    <script>Swal.fire('Registro exitoso', 'El pedido ha sido creado.', 'success');</script>
@endif
@if(session('modify'))
    <script>Swal.fire('Actualización exitosa', 'El pedido ha sido actualizado.', 'success');</script>
@endif
@if(session('destroy'))
    <script>Swal.fire('Eliminación exitosa', 'El pedido ha sido eliminado.', 'success');</script>
@endif

@endsection
