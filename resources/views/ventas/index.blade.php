@extends('layouts.app')

@section('template_title')
    Gestión de Ventas
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header con título y acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 fw-bold">
                <i class="fas fa-cash-register me-2"></i>Registro de Ventas
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ventas</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <a href="{{ route('ventas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Nueva Venta
            </a>
        </div>
    </div>

    <!-- Tarjetas de ventas -->
    <div class="row">
        @foreach ($ventas as $venta)
        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Venta #{{ $venta->id_venta }}</h5>
                        <span class="badge bg-white text-primary">${{ number_format($venta->monto, 2) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm me-3">
                            <i class="fas fa-user fa-2x text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $venta->socio->nom }} {{ $venta->socio->ap }}</h6>
                            <small class="text-muted">Socio</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span><i class="far fa-calendar-alt me-1 text-muted"></i> {{ $venta->fecha_venta }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Detalles:</h6>
                        <ul class="list-group list-group-flush">
                            @foreach ($venta->detallesVentas as $detalle)
                            <li class="list-group-item px-0 py-1 d-flex justify-content-between">
                                <span>{{ $detalle->suplemento->nom_suplemento }}</span>
                                <span>{{ $detalle->cantidad }} x ${{ number_format($detalle->suplemento->precio, 2) }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div>
                            <span class="badge bg-light text-dark">Total: ${{ number_format($venta->monto, 2) }}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" 
                                       data-bs-target="#viewVentaModal{{ $venta->id_venta }}">
                                        <i class="far fa-eye me-1"></i> Ver detalles
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" 
                                       data-bs-target="#editVentaModal{{ $venta->id_venta }}">
                                        <i class="far fa-edit me-1"></i> Editar
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('ventas.destroy', $venta->id_venta) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $venta->id_venta }})">
                                            <i class="far fa-trash-alt me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Venta -->
        <div class="modal fade" id="viewVentaModal{{ $venta->id_venta }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Detalles de Venta #{{ $venta->id_venta }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Información del Socio</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-lg me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $venta->socio->nom }} {{ $venta->socio->ap }}</h5>
                                            <small class="text-muted">Socio</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Información de la Venta</h6>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <div class="p-3 bg-light rounded">
                                                <h6 class="mb-0">Fecha</h6>
                                                <p class="mb-0 fw-bold">{{ $venta->fecha_venta }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="p-3 bg-light rounded">
                                                <h6 class="mb-0">Monto Total</h6>
                                                <p class="mb-0 fw-bold">${{ number_format($venta->monto, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted mb-3">Detalles de Productos</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($venta->detallesVentas as $detalle)
                                            <tr>
                                                <td>{{ $detalle->suplemento->nom_suplemento }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>${{ number_format($detalle->suplemento->precio, 2) }}</td>
                                                <td>${{ number_format($detalle->subtotal, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total:</th>
                                                <th>${{ number_format($venta->monto, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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

        <!-- Modal Editar Venta -->
        <div class="modal fade" id="editVentaModal{{ $venta->id_venta }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Editar Venta #{{ $venta->id_venta }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('ventas.update', $venta->id_venta) }}" id="editForm{{ $venta->id_venta }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Socio</label>
                                    <select name="id_socio" class="form-select" required>
                                        @foreach ($socios as $socio)
                                            <option value="{{ $socio->id_socio }}" {{ $venta->id_socio == $socio->id_socio ? 'selected' : '' }}>
                                                {{ $socio->nombre }} {{ $socio->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" name="fecha_venta" class="form-control" value="{{ $venta->fecha_venta }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Monto Total</label>
                                    <input type="number" name="monto" class="form-control" value="{{ $venta->monto }}" readonly required>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Detalles de Productos</h6>
                            <div id="detallesVenta{{ $venta->id_venta }}">
                                @foreach ($venta->detallesVentas as $detalle)
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <select name="detalles_venta[{{ $loop->index }}][id_suplemento]" class="form-select">
                                            @foreach ($suplementos as $suplemento)
                                                <option value="{{ $suplemento->id_suplemento }}" {{ $detalle->id_suplemento == $suplemento->id_suplemento ? 'selected' : '' }}>
                                                    {{ $suplemento->nom_suplemento }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="detalles_venta[{{ $loop->index }}][cantidad]" class="form-control" value="{{ $detalle->cantidad }}" placeholder="Cantidad">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="detalles_venta[{{ $loop->index }}][precio]" class="form-control" value="{{ $detalle->precio }}" placeholder="Precio" step="0.01">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger w-100" onclick="removeDetalle(this)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addDetalle('detallesVenta{{ $venta->id_venta }}', {{ count($venta->detallesVentas) }})">
                                    <i class="fas fa-plus me-1"></i> Agregar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="editForm{{ $venta->id_venta }}" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $ventas->links() }}
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
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #f8f9fa;
    }
    .avatar-sm {
        width: 36px;
        height: 36px;
    }
    .badge.bg-light {
        color: #212529 !important;
    }
    .list-group-item {
        border-left: 0;
        border-right: 0;
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Función para agregar nuevo detalle de producto
    function addDetalle(containerId, index) {
        const container = document.getElementById(containerId);
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3';
        newRow.innerHTML = `
            <div class="col-md-5">
                <select name="detalles_venta[${index}][id_suplemento]" class="form-select">
                    @foreach ($suplementos as $suplemento)
                        <option value="{{ $suplemento->id_suplemento }}">{{ $suplemento->nom_suplemento }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="detalles_venta[${index}][cantidad]" class="form-control" placeholder="Cantidad">
            </div>
            <div class="col-md-3">
                <input type="number" name="detalles_venta[${index}][precio]" class="form-control" placeholder="Precio" step="0.01">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100" onclick="removeDetalle(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
    }

    // Función para eliminar detalle de producto
    function removeDetalle(button) {
        const row = button.closest('.row');
        row.remove();
    }

    // Confirmación antes de eliminar
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar formulario de eliminación
                $.ajax({
                    url: '/ventas/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        showToast('Éxito', 'Venta eliminada correctamente', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        showToast('Error', 'No se pudo eliminar la venta', 'error');
                    }
                });
            }
        });
    }

    // Mostrar notificaciones Toast
    function showToast(title, message, type) {
        const toastEl = document.getElementById('liveToast');
        const toast = new bootstrap.Toast(toastEl);
        
        document.getElementById('toast-title').textContent = title;
        document.getElementById('toast-message').textContent = message;
        document.getElementById('toast-time').textContent = new Date().toLocaleTimeString();
        
        const toastHeader = toastEl.querySelector('.toast-header');
        toastHeader.classList.remove('bg-primary', 'bg-success', 'bg-danger', 'bg-warning');
        
        switch(type) {
            case 'success':
                toastHeader.classList.add('bg-success');
                break;
            case 'error':
                toastHeader.classList.add('bg-danger');
                break;
            case 'warning':
                toastHeader.classList.add('bg-warning');
                break;
            default:
                toastHeader.classList.add('bg-primary');
        }
        
        toast.show();
    }

    // Mostrar notificación si existe mensaje de éxito
    @if(session('success'))
        showToast('Éxito', '{{ session('success') }}', 'success');
    @endif
</script>
@endsection