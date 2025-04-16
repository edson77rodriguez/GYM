@extends('layouts.app')

@section('template_title')
    Gestión de Asistencias
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header con título y acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 fw-bold">
                <i class="fas fa-calendar-check me-2"></i>Registro de Asistencias
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Asistencias</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAsistenciaModal">
                <i class="fas fa-plus-circle me-1"></i> Nueva Asistencia
            </button>
        </div>
    </div>

    <!-- Tabla de asistencias -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary">Listado de Asistencias</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Socio</th>
                            <th>Fecha</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asistencias as $asistencia)
                        <tr>
                            <td class="fw-bold">#{{ $asistencia->id_asistencia }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-light-primary rounded-circle">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $asistencia->socio->nombre }} {{ $asistencia->socio->apellido }}</h6>
                                        <small class="text-muted">Socio ID: {{ $asistencia->id_socio }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($asistencia->fecha_asi)->format('d/m/Y') }}</td>
                            <td>{{ $asistencia->hora_entrada }}</td>
                            <td>{{ $asistencia->hora_salida ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $asistencia->hora_salida ? 'bg-success' : 'bg-warning' }}">
                                    {{ $asistencia->hora_salida ? 'Completa' : 'Pendiente' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" 
                                       data-bs-target="#viewAsistenciaModal{{ $asistencia->id_asistencia }}" title="Ver detalles">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" 
                                       data-bs-target="#editAsistenciaModal{{ $asistencia->id_asistencia }}" title="Editar">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <form action="{{ route('asistencias.destroy', $asistencia->id_asistencia) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $asistencia->id_asistencia }})" title="Eliminar">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Ver Asistencia -->
                        <div class="modal fade" id="viewAsistenciaModal{{ $asistencia->id_asistencia }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detalles de Asistencia #{{ $asistencia->id_asistencia }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card mb-4 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="text-uppercase text-muted mb-3">Información del Socio</h6>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-lg me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-user fs-4"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">{{ $asistencia->socio->nombre }} {{ $asistencia->socio->apellido }}</h5>
                                                                <small class="text-muted">Socio ID: {{ $asistencia->id_socio }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card mb-4 border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="text-uppercase text-muted mb-3">Detalles de Asistencia</h6>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <div class="p-3 bg-light rounded">
                                                                    <h6 class="mb-0 text-muted">Fecha</h6>
                                                                    <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($asistencia->fecha_asi)->format('d/m/Y') }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <div class="p-3 bg-light rounded">
                                                                    <h6 class="mb-0 text-muted">Estado</h6>
                                                                    <p class="mb-0 fw-bold">
                                                                        <span class="badge {{ $asistencia->hora_salida ? 'bg-success' : 'bg-warning' }}">
                                                                            {{ $asistencia->hora_salida ? 'Completa' : 'Pendiente' }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <div class="p-3 bg-light rounded">
                                                                    <h6 class="mb-0 text-muted">Hora Entrada</h6>
                                                                    <p class="mb-0 fw-bold">{{ $asistencia->hora_entrada }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <div class="p-3 bg-light rounded">
                                                                    <h6 class="mb-0 text-muted">Hora Salida</h6>
                                                                    <p class="mb-0 fw-bold">{{ $asistencia->hora_salida ?? 'No registrada' }}</p>
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

                        <!-- Modal Editar Asistencia -->
                        <div class="modal fade" id="editAsistenciaModal{{ $asistencia->id_asistencia }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Editar Asistencia #{{ $asistencia->id_asistencia }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('asistencias.update', $asistencia->id_asistencia) }}" id="editForm{{ $asistencia->id_asistencia }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Socio</label>
                                                <select name="id_socio" class="form-select" required>
                                                    @foreach ($socios as $socio)
                                                        <option value="{{ $socio->id_socio }}" {{ $asistencia->id_socio == $socio->id_socio ? 'selected' : '' }}>
                                                            {{ $socio->nombre }} {{ $socio->apellido }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha</label>
                                                <input type="date" name="fecha_asi" class="form-control" value="{{ $asistencia->fecha_asi }}" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Hora Entrada</label>
                                                    <input type="time" name="hora_entrada" class="form-control" value="{{ $asistencia->hora_entrada }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Hora Salida</label>
                                                    <input type="time" name="hora_salida" class="form-control" value="{{ $asistencia->hora_salida }}">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" form="editForm{{ $asistencia->id_asistencia }}" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $asistencias->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Asistencia -->
<div class="modal fade" id="createAsistenciaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nueva Asistencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('asistencias.store') }}" id="createAsistenciaForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Socio</label>
                        <select name="id_socio" class="form-select" required>
                            <option value="">Seleccione un socio</option>
                            @foreach ($socios as $socio)
                                <option value="{{ $socio->id_socio }}">
                                    {{ $socio->nombre }} {{ $socio->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha_asi" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora Entrada</label>
                            <input type="time" name="hora_entrada" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora Salida</label>
                            <input type="time" name="hora_salida" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="createAsistenciaForm" class="btn btn-primary">Registrar Asistencia</button>
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
        // Mostrar notificaciones
        @if(session('success'))
            showToast('Éxito', '{{ session('success') }}', 'success');
        @endif
    });

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
                    url: '/asistencias/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        showToast('Éxito', 'Asistencia eliminada correctamente', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        showToast('Error', 'No se pudo eliminar la asistencia', 'error');
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
</script>
@endsection