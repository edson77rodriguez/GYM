@extends('layouts.app')

@section('template_title')
    Gestión de Pedidos
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header con título y acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 fw-bold">
                <i class="fas fa-clipboard-list me-2"></i>Gestión de Pedidos
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPedidoModal">
                <i class="fas fa-plus-circle me-1"></i> Nuevo Pedido
            </button>
        </div>
    </div>

    <!-- Tabla de pedidos -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Listado de Pedidos</h6>
                <div class="input-group w-25">
                    <input type="text" id="search" class="form-control form-control-sm" placeholder="Buscar...">
                    <button class="btn btn-outline-secondary btn-sm" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Suplemento</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                        <tr>
                            <td class="fw-bold">#{{ $pedido->id_pedido }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-light-primary rounded-circle">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }}</h6>
                                        <small class="text-muted">Proveedor</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-light-success rounded-circle">
                                            <i class="fas fa-pills"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $pedido->suplemento->nom_suplemento }}</h6>
                                        <small class="text-muted">Suplemento</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill">{{ $pedido->cantidad }} unidades</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-success">Completado</span>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" 
                                       data-bs-target="#viewPedidoModal{{ $pedido->id_pedido }}">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" 
                                       data-bs-target="#editPedidoModal{{ $pedido->id_pedido }}">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form id="deleteForm{{ $pedido->id_pedido }}" action="{{ route('pedidos.destroy', $pedido->id_pedido) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                       <!-- Versión mejorada con tooltip y confirmación -->
<button class="btn btn-danger btn-sm delete-btn" 
data-id="{{ $pedido->id_pedido }}"
data-url="{{ route('pedidos.destroy', $pedido->id_pedido) }}"
title="Eliminar pedido">
<i class="fas fa-trash-alt"></i> Eliminar
</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Ver Pedido -->
                        <div class="modal fade" id="viewPedidoModal{{ $pedido->id_pedido }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detalles del Pedido #{{ $pedido->id_pedido }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card mb-4 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="text-uppercase text-muted mb-3">Información del Proveedor</h6>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-lg me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-user-tie fs-4"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">{{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }} {{ $pedido->proveedor->persona->am ?? '' }}</h5>
                                                                <small class="text-muted">Proveedor</small>
                                                            </div>
                                                        </div>
                                                        <ul class="list-unstyled">
                                                            <li class="mb-2"><i class="fas fa-phone me-2 text-muted"></i> {{ $pedido->proveedor->persona->telefono ?? 'N/A' }}</li>
                                                            <li class="mb-2"><i class="fas fa-envelope me-2 text-muted"></i> {{ $pedido->proveedor->persona->correo ?? 'N/A' }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card mb-4 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="text-uppercase text-muted mb-3">Detalles del Pedido</h6>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-lg me-3 bg-light-success rounded-circle d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-pills fs-4"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">{{ $pedido->suplemento->nom_suplemento }}</h5>
                                                                <small class="text-muted">Suplemento</small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <div class="p-3 bg-light rounded">
                                                                    <h6 class="mb-0 text-muted">Cantidad</h6>
                                                                    <p class="mb-0 fw-bold">{{ $pedido->cantidad }} unidades</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <div class="p-3 bg-light rounded">
                                                                    <h6 class="mb-0 text-muted">Fecha</h6>
                                                                    <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Pedido -->
                        <div class="modal fade" id="editPedidoModal{{ $pedido->id_pedido }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Editar Pedido #{{ $pedido->id_pedido }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('pedidos.update', $pedido->id_pedido) }}" id="editForm{{ $pedido->id_pedido }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Proveedor</label>
                                                <select name="id_proveedor" class="form-select" required>
                                                    @foreach ($proveedores as $proveedor)
                                                        <option value="{{ $proveedor->id_proveedor }}" {{ $pedido->id_proveedor == $proveedor->id_proveedor ? 'selected' : '' }}>
                                                            {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Suplemento</label>
                                                <select name="id_suplemento" class="form-select" required>
                                                    @foreach ($suplementos as $suplemento)
                                                        <option value="{{ $suplemento->id_suplemento }}" {{ $pedido->id_suplemento == $suplemento->id_suplemento ? 'selected' : '' }}>
                                                            {{ $suplemento->nom_suplemento }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Cantidad</label>
                                                    <input type="number" name="cantidad" value="{{ $pedido->cantidad }}" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Fecha</label>
                                                    <input type="date" name="fecha_pedido" value="{{ $pedido->fecha_pedido }}" class="form-control" required>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" form="editForm{{ $pedido->id_pedido }}" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Mostrando {{ $pedidos->firstItem() }} a {{ $pedidos->lastItem() }} de {{ $pedidos->total() }} registros
                </div>
                <nav aria-label="Page navigation">
                    {{ $pedidos->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Pedido -->
<div class="modal fade" id="createPedidoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nuevo Pedido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('pedidos.store') }}" id="createPedidoForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Proveedor</label>
                        <select name="id_proveedor" class="form-select" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id_proveedor }}">
                                    {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Suplemento</label>
                        <select name="id_suplemento" class="form-select" required>
                            <option value="">Seleccione un suplemento</option>
                            @foreach ($suplementos as $suplemento)
                                <option value="{{ $suplemento->id_suplemento }}">
                                    {{ $suplemento->nom_suplemento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha del Pedido</label>
                            <input type="date" name="fecha_pedido" class="form-control" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="createPedidoForm" class="btn btn-primary">Crear Pedido</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast para notificaciones -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto" id="toast-title">Notificación</strong>
            <small id="toast-time">Ahora</small>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-white" id="toast-message"></div>
    </div>
</div>

@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-title {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
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
    .modal-header {
        padding: 1rem 1.5rem;
    }
    .modal-title {
        font-weight: 600;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
        font-size: 0.875rem;
    }
    .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Configuración global de SweetAlert2
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger mx-2',
                cancelButton: 'btn btn-secondary mx-2'
            },
            buttonsStyling: false,
            allowOutsideClick: false
        });

        // Manejar clic en botones de eliminar
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const url = $(this).data('url');
            
            swalWithBootstrapButtons.fire({
                title: '¿Confirmar eliminación?',
                html: `<p>Estás a punto de eliminar el pedido <strong>#${id}</strong></p>
                       <p class='text-danger'>Esta acción no se puede deshacer</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
                cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                reverseButtons: true,
                backdrop: `
                    rgba(0,0,0,0.7)
                    url("{{ asset('img/trash-animation.gif') }}")
                    left top
                    no-repeat
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear formulario dinámico para enviar la solicitud DELETE
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    
                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                    
                    // Mostrar loader mientras se procesa
                    swalWithBootstrapButtons.fire({
                        title: 'Eliminando...',
                        html: 'Por favor espere',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection