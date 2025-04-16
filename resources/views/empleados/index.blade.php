@extends('layouts.app')

@section('template_title')
    Gestión de Empleados
@endsection
@section('styles')
<style>
    /* Estilos para SweetAlert */
    .swal2-popup {
        font-size: 1rem;
        border-radius: 0.5rem;
    }
    .swal2-title {
        font-size: 1.25rem;
    }
    .swal2-html-container {
        font-size: 1rem;
    }
    .delete-empleado {
        transition: all 0.2s;
    }
    .delete-empleado:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header con título y acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 fw-bold">
                <i class="fas fa-users me-2"></i>Gestión de Empleados
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Empleados</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmpleadoModal">
                <i class="fas fa-user-plus me-1"></i> Nuevo Empleado
            </button>
        </div>
    </div>

    <!-- Tabla de empleados -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Listado de Empleados</h6>
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
                            <th>Empleado</th>
                            <th>Contacto</th>
                            <th>Disponibilidad</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empleados as $empleado)
                        <tr>
                            <td class="fw-bold">#{{ $empleado->id_empleado }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-light-primary rounded-circle">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $empleado->persona->nom }} {{ $empleado->persona->ap }}</h6>
                                        <small class="text-muted">{{ $empleado->persona->am ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted d-block"><i class="fas fa-phone me-1"></i> {{ $empleado->persona->telefono ?? 'N/A' }}</small>
                                <small class="text-muted"><i class="fas fa-envelope me-1"></i> {{ $empleado->persona->correo ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $empleado->disponibilidad->desc_dispo == 'Disponible' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $empleado->disponibilidad->desc_dispo }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($empleado->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" 
                                       data-bs-target="#viewEmpleadoModal{{ $empleado->id_empleado }}" title="Ver detalles">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" 
                                       data-bs-target="#editEmpleadoModal{{ $empleado->id_empleado }}" title="Editar">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-empleado" 
                                        data-id="{{ $empleado->id_empleado }}"
                                        data-name="{{ $empleado->persona->nom }} {{ $empleado->persona->ap }}"
                                        title="Eliminar">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Ver Empleado -->
                        <div class="modal fade" id="viewEmpleadoModal{{ $empleado->id_empleado }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detalles del Empleado</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card mb-4 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="text-uppercase text-muted mb-3">Información Personal</h6>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-lg me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-user-tie fs-4"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">{{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am ?? '' }}</h5>
                                                                <small class="text-muted">Empleado ID: {{ $empleado->id_empleado }}</small>
                                                            </div>
                                                        </div>
                                                        <ul class="list-unstyled">
                                                            <li class="mb-2"><i class="fas fa-id-card me-2 text-muted"></i> <strong>ID:</strong> {{ $empleado->id_empleado }}</li>
                                                            <li class="mb-2"><i class="fas fa-phone me-2 text-muted"></i> <strong>Teléfono:</strong> {{ $empleado->persona->telefono ?? 'N/A' }}</li>
                                                            <li class="mb-2"><i class="fas fa-envelope me-2 text-muted"></i> <strong>Email:</strong> {{ $empleado->persona->correo ?? 'N/A' }}</li>
                                                            <li class="mb-2"><i class="fas fa-calendar-alt me-2 text-muted"></i> <strong>Registrado:</strong> {{ \Carbon\Carbon::parse($empleado->created_at)->format('d/m/Y') }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card mb-4 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="text-uppercase text-muted mb-3">Estado Laboral</h6>
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
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Empleado -->
                        <div class="modal fade" id="editEmpleadoModal{{ $empleado->id_empleado }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Editar Empleado #{{ $empleado->id_empleado }}</h5>
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
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Mostrando {{ $empleados->firstItem() }} a {{ $empleados->lastItem() }} de {{ $empleados->total() }} registros
                </div>
                <nav aria-label="Page navigation">
                    {{ $empleados->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Empleado -->
<div class="modal fade" id="createEmpleadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Configuración global de SweetAlert
        const swalWithBootstrap = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger mx-2',
                cancelButton: 'btn btn-secondary mx-2'
            },
            buttonsStyling: false
        });

        // Eliminar empleado
        $(document).on('click', '.delete-empleado', function() {
            const empleadoId = $(this).data('id');
            const empleadoName = $(this).data('name');
            
            swalWithBootstrap.fire({
                title: '¿Eliminar empleado?',
                html: `Estás a punto de eliminar a <strong>${empleadoName}</strong><br>Esta acción no se puede deshacer`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
                cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                reverseButtons: true,
                backdrop: `
                    rgba(0,0,0,0.6)
                    url("{{ asset('img/trash-animation.gif') }}")
                    left top
                    no-repeat
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear formulario dinámico
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/empleados/${empleadoId}`;
                    
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
                    
                    // Mostrar loader mientras se procesa
                    swalWithBootstrap.fire({
                        title: 'Eliminando...',
                        html: 'Por favor espere',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            form.submit();
                        }
                    });
                }
            });
        });

        // Búsqueda en la tabla y otras funciones...
    });

    // Resto de tus funciones...
</script>
@endsection