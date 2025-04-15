@extends('layouts.app')

@section('template_title')
    Gestión de Mantenimientos
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-warning text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-tools me-2"></i>Programación de Mantenimientos</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-light me-2" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Volver al Inicio') }}
                            </button>
                            <button class="btn btn-light text-warning fw-bold" data-bs-toggle="modal" data-bs-target="#createMantenimientoModal">
                                <i class="fas fa-plus-circle me-1"></i> {{ __('Nuevo Mantenimiento') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($mantenimientos->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4 class="fw-bold">No hay mantenimientos programados</h4>
                            <p class="mb-0">Comienza agregando tu primer mantenimiento</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Equipo</th>
                                        <th>Técnico</th>
                                        <th class="text-center">Fecha Programada</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mantenimientos as $mantenimiento)
                                    <tr class="hover-shadow">
                                        <td class="text-center fw-bold">{{ $mantenimiento->id_mantenimiento }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title bg-light rounded-circle text-warning fw-bold">
                                                        <i class="fas fa-dumbbell"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $mantenimiento->equipo->nom_equipo }}</h6>
                                                    <small class="text-muted">ID: {{ $mantenimiento->equipo->id_equipo }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $mantenimiento->empleado->persona->nom }} 
                                            {{ $mantenimiento->empleado->persona->ap }} 
                                            {{ $mantenimiento->empleado->persona->am }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-calendar-day me-1 text-warning"></i> 
                                                {{ \Carbon\Carbon::parse($mantenimiento->fecha_programada)->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $estadoClass = [
                                                    'Pendiente' => 'secondary',
                                                    'En Proceso' => 'info',
                                                    'Completado' => 'success',
                                                    'Cancelado' => 'danger'
                                                ][$mantenimiento->desc_estado] ?? 'warning';
                                            @endphp
                                            <span class="badge bg-{{ $estadoClass }} rounded-pill">
                                                {{ $mantenimiento->desc_estado }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-info rounded-circle" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewMantenimientoModal{{ $mantenimiento->id_mantenimiento }}"
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <button class="btn btn-sm btn-outline-primary rounded-circle" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editMantenimientoModal{{ $mantenimiento->id_mantenimiento }}"
                                                        title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <form onsubmit="event.preventDefault(); confirmDelete({{ $mantenimiento->id_mantenimiento }});" 
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Ver Mantenimiento -->
                                    <div class="modal fade" id="viewMantenimientoModal{{ $mantenimiento->id_mantenimiento }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-clipboard-list me-2"></i>Detalles del Mantenimiento
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-bold text-muted">ID Mantenimiento:</h6>
                                                            <p>{{ $mantenimiento->id_mantenimiento }}</p>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-bold text-muted">Fecha Registro:</h6>
                                                            <p>{{ $mantenimiento->created_at->format('d/m/Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-bold text-muted">Equipo:</h6>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title bg-light rounded-circle text-warning">
                                                                        <i class="fas fa-dumbbell"></i>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-0">{{ $mantenimiento->equipo->nom_equipo }}</p>
                                                                    <small class="text-muted">ID: {{ $mantenimiento->equipo->id_equipo }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-bold text-muted">Técnico Asignado:</h6>
                                                            <p>
                                                                {{ $mantenimiento->empleado->persona->nom }} 
                                                                {{ $mantenimiento->empleado->persona->ap }} 
                                                                {{ $mantenimiento->empleado->persona->am }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-bold text-muted">Fecha Programada:</h6>
                                                            <p>
                                                                <i class="fas fa-calendar-day me-1 text-warning"></i> 
                                                                {{ \Carbon\Carbon::parse($mantenimiento->fecha_programada)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-bold text-muted">Estado:</h6>
                                                            <span class="badge bg-{{ $estadoClass }} rounded-pill">
                                                                {{ $mantenimiento->desc_estado }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i> Cerrar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Editar Mantenimiento -->
                                    <div class="modal fade" id="editMantenimientoModal{{ $mantenimiento->id_mantenimiento }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-edit me-2"></i>Editar Mantenimiento
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('mantenimientos.update', $mantenimiento->id_mantenimiento) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Equipo</label>
                                                            <select name="id_equipo" class="form-select border-2" required>
                                                                <option value="" disabled>Seleccione equipo</option>
                                                                @foreach ($equipos as $equipo)
                                                                    <option value="{{ $equipo->id_equipo }}" {{ $mantenimiento->id_equipo == $equipo->id_equipo ? 'selected' : '' }}>
                                                                        {{ $equipo->nom_equipo }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Técnico</label>
                                                            <select name="id_empleado" class="form-select border-2" required>
                                                                <option value="" disabled>Seleccione técnico</option>
                                                                @foreach ($empleados as $empleado)
                                                                    <option value="{{ $empleado->id_empleado }}" {{ $mantenimiento->id_empleado == $empleado->id_empleado ? 'selected' : '' }}>
                                                                        {{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Fecha Programada</label>
                                                                <input type="date" name="fecha_programada" 
                                                                       value="{{ $mantenimiento->fecha_programada }}" 
                                                                       class="form-control border-2" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Estado</label>
                                                                <select name="desc_estado" class="form-select border-2">
                                                                    <option value="Pendiente" {{ $mantenimiento->desc_estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                                    <option value="En Proceso" {{ $mantenimiento->desc_estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                                                    <option value="Completado" {{ $mantenimiento->desc_estado == 'Completado' ? 'selected' : '' }}>Completado</option>
                                                                    <option value="Cancelado" {{ $mantenimiento->desc_estado == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-1"></i> Cancelar
                                                        </button>
                                                        <button type="submit" class="btn btn-info text-white">
                                                            <i class="fas fa-save me-1"></i> Guardar Cambios
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if(method_exists($mantenimientos, 'hasPages') && $mantenimientos->hasPages())
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-center">
                                {{ $mantenimientos->links() }}
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Mantenimiento -->
<div class="modal fade" id="createMantenimientoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Mantenimiento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('mantenimientos.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Equipo</label>
                        <select name="id_equipo" class="form-select border-2" required>
                            <option value="" selected disabled>Seleccione equipo</option>
                            @foreach ($equipos as $equipo)
                                <option value="{{ $equipo->id_equipo }}">{{ $equipo->nom_equipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Técnico</label>
                        <select name="id_empleado" class="form-select border-2" required>
                            <option value="" selected disabled>Seleccione técnico</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}">
                                    {{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fecha Programada</label>
                            <input type="date" name="fecha_programada" 
                                   class="form-control border-2" 
                                   min="{{ date('Y-m-d') }}" 
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Estado</label>
                            <select name="desc_estado" class="form-select border-2">
                                <option value="Pendiente" selected>Pendiente</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Programar Mantenimiento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Confirmar eliminación?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Sí, eliminar',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Cancelar',
            backdrop: `
                rgba(0,0,123,0.4)
                url("{{ asset('img/trash-effect.gif') }}")
                left top
                no-repeat
            `
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/mantenimientos/' + id;
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@if(session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@endsection