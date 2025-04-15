@extends('layouts.app')

@section('template_title')
    Gestión de Pedidos
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header con acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 text-primary fw-bold">
            <i class="fas fa-clipboard-list me-2"></i>Pedidos
        </h1>
        <div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPedidoModal">
                <i class="fas fa-plus-circle me-1"></i> Nuevo Pedido
            </button>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="search" class="form-label mb-0">Buscar:</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                        <input type="text" id="search" class="form-control" placeholder="Buscar pedidos...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="filter-date" class="form-label mb-0">Filtrar por fecha:</label>
                    <input type="date" id="filter-date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="filter-supplier" class="form-label mb-0">Filtrar por proveedor:</label>
                    <select id="filter-supplier" class="form-select">
                        <option value="">Todos</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->persona->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-dark w-100" id="reset-filters">
                        <i class="fas fa-sync-alt me-1"></i> Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de pedidos -->
    <div class="row" id="pedidos-container">
        @foreach ($pedidos as $pedido)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4 pedido-card" 
             data-id="{{ $pedido->id_pedido }}"
             data-date="{{ $pedido->fecha_pedido }}"
             data-supplier="{{ $pedido->id_proveedor }}"
             data-search="{{ $pedido->id_pedido }} {{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }} {{ $pedido->suplemento->nom_suplemento }}">
            <div class="card h-100 border-0 shadow-hover">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Pedido #{{ $pedido->id_pedido }}</h5>
                        <span class="badge bg-white text-primary">{{ $pedido->cantidad }} unidades</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm me-3">
                            <i class="fas fa-truck fa-2x text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }}</h6>
                            <small class="text-muted">Proveedor</small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm me-3">
                            <i class="fas fa-pills fa-2x text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $pedido->suplemento->nom_suplemento }}</h6>
                            <small class="text-muted">Suplemento</small>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div>
                            <i class="far fa-calendar-alt me-1 text-muted"></i>
                            <small>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d M Y') }}</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" 
                                       data-bs-target="#viewPedidoModal{{ $pedido->id_pedido }}">
                                        <i class="far fa-eye me-1"></i> Ver detalles
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" 
                                       data-bs-target="#editPedidoModal{{ $pedido->id_pedido }}">
                                        <i class="far fa-edit me-1"></i> Editar
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('pedidos.destroy', $pedido->id_pedido) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $pedido->id_pedido }})">
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

        <!-- Modal Ver Pedido -->
        <div class="modal fade" id="viewPedidoModal{{ $pedido->id_pedido }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Detalles del Pedido #{{ $pedido->id_pedido }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Información del Proveedor</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-lg me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user-tie fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }} {{ $pedido->proveedor->persona->am }}</h5>
                                            <small class="text-muted">Proveedor</small>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-phone me-2 text-muted"></i> {{ $pedido->proveedor->persona->telefono ?? 'N/A' }}</li>
                                        <li class="mb-2"><i class="fas fa-envelope me-2 text-muted"></i> {{ $pedido->proveedor->persona->correo ?? 'N/A' }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Detalles del Pedido</h6>
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
                                        <div class="col-6">
                                            <div class="p-3 bg-light rounded">
                                                <h6 class="mb-0">Cantidad</h6>
                                                <p class="mb-0 fw-bold">{{ $pedido->cantidad }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 bg-light rounded">
                                                <h6 class="mb-0">Fecha</h6>
                                                <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</p>
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
            <div class="modal-dialog">
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
    </div>

    <!-- Paginación -->
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $pedidos->links() }}
        </div>
    </div>

    <!-- Mensaje cuando no hay pedidos -->
    <div class="row d-none" id="no-results">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-clipboard-list fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No se encontraron pedidos</h4>
                    <p class="text-muted">Intenta ajustar tus filtros de búsqueda</p>
                    <button class="btn btn-outline-primary" id="reset-search">Limpiar búsqueda</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Pedido -->
<div class="modal fade" id="createPedidoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
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
        <div class="toast-header">
            <strong class="me-auto" id="toast-title">Notificación</strong>
            <small id="toast-time">Ahora</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-message"></div>
    </div>
</div>

@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    .card.shadow-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
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
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }
    .border-light {
        border: 1px solid rgba(0,0,0,0.05);
    }
    #no-results {
        min-height: 300px;
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Filtrar pedidos
        $('#search, #filter-date, #filter-supplier').on('keyup change', function() {
            filterPedidos();
        });

        // Resetear filtros
        $('#reset-filters, #reset-search').on('click', function() {
            $('#search').val('');
            $('#filter-date').val('');
            $('#filter-supplier').val('').trigger('change');
            filterPedidos();
        });

        function filterPedidos() {
            let search = $('#search').val().toLowerCase();
            let date = $('#filter-date').val();
            let supplier = $('#filter-supplier').val();
            let hasResults = false;

            $('.pedido-card').each(function() {
                let card = $(this);
                let cardSearch = card.data('search').toLowerCase();
                let cardDate = card.data('date');
                let cardSupplier = card.data('supplier').toString();
                
                // Asegúrate que la fecha coincida (comparando solo la parte de la fecha)
                let matchesDate = true;
                if (date !== '') {
                    let cardDateObj = new Date(cardDate);
                    let filterDateObj = new Date(date);
                    matchesDate = cardDateObj.toDateString() === filterDateObj.toDateString();
                }
                
                let matchesSearch = search === '' || cardSearch.includes(search);
                let matchesSupplier = supplier === '' || cardSupplier === supplier;
                
                if (matchesSearch && matchesDate && matchesSupplier) {
                    card.show();
                    hasResults = true;
                } else {
                    card.hide();
                }
            });

            if (hasResults) {
                $('#no-results').addClass('d-none');
            } else {
                $('#no-results').removeClass('d-none');
            }
        }

        // Mostrar notificaciones
        @if(session('success'))
            showToast('Éxito', '{{ session('success') }}', 'success');
        @endif
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar pedido?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar formulario de eliminación
                $.ajax({
                    url: '/pedidos/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        showToast('Éxito', 'Pedido eliminado correctamente', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        showToast('Error', 'No se pudo eliminar el pedido', 'error');
                    }
                });
            }
        });
    }

    function showToast(title, message, type) {
        const toastEl = document.getElementById('liveToast');
        const toast = new bootstrap.Toast(toastEl);
        
        // Configurar el toast
        document.getElementById('toast-title').textContent = title;
        document.getElementById('toast-message').textContent = message;
        document.getElementById('toast-time').textContent = new Date().toLocaleTimeString();
        
        // Cambiar colores según el tipo
        const toastHeader = toastEl.querySelector('.toast-header');
        toastHeader.classList.remove('bg-primary', 'bg-success', 'bg-danger', 'bg-warning');
        
        switch(type) {
            case 'success':
                toastHeader.classList.add('bg-success', 'text-white');
                break;
            case 'error':
                toastHeader.classList.add('bg-danger', 'text-white');
                break;
            case 'warning':
                toastHeader.classList.add('bg-warning', 'text-dark');
                break;
            default:
                toastHeader.classList.add('bg-primary', 'text-white');
        }
        
        toast.show();
    }
</script>
@endsection