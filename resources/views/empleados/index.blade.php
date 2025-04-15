@extends('layouts.app')

@section('template_title')
    Gestión de Empleados
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header con acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 text-primary fw-bold">
            <i class="fas fa-users me-2"></i>Empleados
        </h1>
        <div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmpleadoModal">
                <i class="fas fa-user-plus me-1"></i> Nuevo Empleado
            </button>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <label for="search" class="form-label mb-0">Buscar:</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                        <input type="text" id="search" class="form-control" placeholder="Buscar empleados...">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="filter-availability" class="form-label mb-0">Filtrar por disponibilidad:</label>
                    <select id="filter-availability" class="form-select">
                        <option value="">Todos</option>
                        @foreach($disponibilidades as $disponibilidad)
                            <option value="{{ $disponibilidad->id_disponibilidad }}">{{ $disponibilidad->desc_dispo }}</option>
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

    <!-- Tarjetas de empleados -->
    <div class="row" id="empleados-container">
        @foreach ($empleados as $empleado)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4 empleado-card" 
             data-id="{{ $empleado->id_empleado }}"
             data-availability="{{ $empleado->id_disponibilidad }}"
             data-search="{{ $empleado->id_empleado }} {{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}">
            <div class="card h-100 border-0 shadow-hover">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ $empleado->persona->nom }} {{ $empleado->persona->ap }}</h5>
                        <span class="badge {{ $empleado->disponibilidad->desc_dispo == 'Disponible' ? 'bg-success' : 'bg-warning' }}">
                            {{ $empleado->disponibilidad->desc_dispo }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm me-3">
                            <i class="fas fa-user-tie fa-2x text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}</h6>
                            <small class="text-muted">Empleado ID: {{ $empleado->id_empleado }}</small>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div>
                            <i class="fas fa-calendar-check me-1 text-muted"></i>
                            <small>Registrado: {{ \Carbon\Carbon::parse($empleado->created_at)->format('d/m/Y') }}</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" 
                                       data-bs-target="#viewEmpleadoModal{{ $empleado->id_empleado }}">
                                        <i class="far fa-eye me-1"></i> Ver detalles
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" 
                                       data-bs-target="#editEmpleadoModal{{ $empleado->id_empleado }}">
                                        <i class="far fa-edit me-1"></i> Editar
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $empleado->id_empleado }})">
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

        <!-- Modal Ver Empleado -->
        <div class="modal fade" id="viewEmpleadoModal{{ $empleado->id_empleado }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Detalles del Empleado</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Información Personal</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-lg me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user-tie fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}</h5>
                                            <small class="text-muted">Empleado ID: {{ $empleado->id_empleado }}</small>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-id-card me-2 text-muted"></i> ID: {{ $empleado->id_empleado }}</li>
                                        <li class="mb-2"><i class="fas fa-calendar-alt me-2 text-muted"></i> Registrado: {{ \Carbon\Carbon::parse($empleado->created_at)->format('d/m/Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Estado Laboral</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-lg me-3 bg-light-success rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user-clock fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $empleado->disponibilidad->desc_dispo }}</h5>
                                            <small class="text-muted">Disponibilidad</small>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-light rounded">
                                        <h6 class="mb-2">Información Adicional</h6>
                                        <p class="mb-0 small text-muted">Última actualización: {{ \Carbon\Carbon::parse($empleado->updated_at)->format('d/m/Y H:i') }}</p>
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

        <!-- Modal Editar Empleado -->
        <div class="modal fade" id="editEmpleadoModal{{ $empleado->id_empleado }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Editar Empleado</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('empleados.update', $empleado->id_empleado) }}" id="editForm{{ $empleado->id_empleado }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Persona</label>
                                <select name="id_persona" class="form-select" required>
                                    @foreach ($personas as $persona)
                                        <option value="{{ $persona->id_persona }}" {{ $empleado->id_persona == $persona->id_persona ? 'selected' : '' }}>
                                            {{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Disponibilidad</label>
                                <select name="id_disponibilidad" class="form-select" required>
                                    @foreach ($disponibilidades as $disponibilidad)
                                        <option value="{{ $disponibilidad->id_disponibilidad }}" {{ $empleado->id_disponibilidad == $disponibilidad->id_disponibilidad ? 'selected' : '' }}>
                                            {{ $disponibilidad->desc_dispo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="editForm{{ $empleado->id_empleado }}" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $empleados->links() }}
        </div>
    </div>

    <!-- Mensaje cuando no hay empleados -->
    <div class="row d-none" id="no-results">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-users-slash fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No se encontraron empleados</h4>
                    <p class="text-muted">Intenta ajustar tus filtros de búsqueda</p>
                    <button class="btn btn-outline-primary" id="reset-search">Limpiar búsqueda</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Empleado -->
<div class="modal fade" id="createEmpleadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nuevo Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('empleados.store') }}" id="createEmpleadoForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Persona</label>
                        <select name="id_persona" class="form-select" required>
                            <option value="">Seleccione una persona</option>
                            @foreach ($personas as $persona)
                                <option value="{{ $persona->id_persona }}">
                                    {{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Disponibilidad</label>
                        <select name="id_disponibilidad" class="form-select" required>
                            <option value="">Seleccione disponibilidad</option>
                            @foreach ($disponibilidades as $disponibilidad)
                                <option value="{{ $disponibilidad->id_disponibilidad }}">
                                    {{ $disponibilidad->desc_dispo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="createEmpleadoForm" class="btn btn-primary">Crear Empleado</button>
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
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Luego Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Luego SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Tus scripts personalizados al final -->
<script>
    // Tu código JavaScript aquí
</script>
<script>
    $(document).ready(function() {
        // Filtrar empleados
        $('#search, #filter-availability').on('keyup change', function() {
            filterEmpleados();
        });

        // Resetear filtros
        $('#reset-filters, #reset-search').on('click', function() {
            $('#search').val('');
            $('#filter-availability').val('').trigger('change');
            filterEmpleados();
        });

        function filterEmpleados() {
            let search = $('#search').val().toLowerCase();
            let availability = $('#filter-availability').val();
            let hasResults = false;

            $('.empleado-card').each(function() {
                let card = $(this);
                let cardSearch = card.data('search').toLowerCase();
                let cardAvailability = card.data('availability').toString();
                
                let matchesSearch = search === '' || cardSearch.includes(search);
                let matchesAvailability = availability === '' || cardAvailability === availability;
                
                if (matchesSearch && matchesAvailability) {
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
            title: '¿Eliminar empleado?',
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
                    url: '/empleados/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        showToast('Éxito', 'Empleado eliminado correctamente', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        showToast('Error', 'No se pudo eliminar el empleado', 'error');
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