@extends('layouts.app')

@section('template_title')
    Gestión de Socios
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-users me-2"></i>Registro de Socios</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-light me-2" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Volver al Inicio') }}
                            </button>
                            <button class="btn btn-light text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#createSocioModal">
                                <i class="fas fa-user-plus me-1"></i> {{ __('Nuevo Socio') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($socios->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4 class="fw-bold">No hay socios registrados</h4>
                            <p class="mb-0">Comienza agregando tu primer socio</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Nombre Completo</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Inscripción</th>
                                        <th class="text-center">Vencimiento</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($socios as $socio)
                                    <tr class="hover-shadow">
                                        <td class="text-center fw-bold">{{ $socio->id_socio }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title bg-light rounded-circle text-primary fw-bold">
                                                        {{ substr($socio->persona->nom, 0, 1) }}{{ substr($socio->persona->ap, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</h6>
                                                    <small class="text-muted">ID: {{ $socio->persona->id_persona }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $estadoClass = [
                                                    'Activo' => 'success',
                                                    'Inactivo' => 'secondary',
                                                    'Suspendido' => 'warning',
                                                    'Vencido' => 'danger'
                                                ][$socio->estadoMembresia->nom_estado] ?? 'info';
                                            @endphp
                                            <span class="badge bg-{{ $estadoClass }} rounded-pill">
                                                <i class="fas fa-circle me-1 small"></i> {{ $socio->estadoMembresia->nom_estado }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-calendar-check me-1 text-primary"></i> {{ $socio->fecha_inscripcion->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $vencimientoClass = now()->gt($socio->fecha_vencimiento) ? 'danger' : 'success';
                                            @endphp
                                            <span class="badge bg-{{ $vencimientoClass }}-light text-{{ $vencimientoClass }}">
                                                <i class="fas fa-calendar-times me-1"></i> {{ $socio->fecha_vencimiento->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-info rounded-circle" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewSocioModal{{ $socio->id_socio }}"
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <button class="btn btn-sm btn-outline-primary rounded-circle" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editSocioModal{{ $socio->id_socio }}"
                                                        title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <form onsubmit="event.preventDefault(); confirmDelete({{ $socio->id_socio }});" 
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

                                    <!-- Modal Ver Socio -->
                                    <div class="modal fade" id="viewSocioModal{{ $socio->id_socio }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-id-card me-2"></i>Detalles del Socio
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4 text-center mb-4 mb-md-0">
                                                            <div class="avatar-xxl mb-3">
                                                                <div class="avatar-title bg-light rounded-circle text-primary fw-bold display-4">
                                                                    {{ substr($socio->persona->nom, 0, 1) }}{{ substr($socio->persona->ap, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <h5 class="fw-bold">{{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</h5>
                                                            <span class="badge bg-{{ $estadoClass }} rounded-pill">
                                                                {{ $socio->estadoMembresia->nom_estado }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <h6 class="fw-bold text-muted">ID Socio:</h6>
                                                                    <p>{{ $socio->id_socio }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <h6 class="fw-bold text-muted">ID Persona:</h6>
                                                                    <p>{{ $socio->persona->id_persona }}</p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <h6 class="fw-bold text-muted">Fecha Inscripción:</h6>
                                                                    <p><i class="fas fa-calendar-check me-2 text-primary"></i> {{ $socio->fecha_inscripcion->format('d/m/Y') }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <h6 class="fw-bold text-muted">Fecha Vencimiento:</h6>
                                                                    <p class="text-{{ $vencimientoClass }}">
                                                                        <i class="fas fa-calendar-times me-2"></i> {{ $socio->fecha_vencimiento->format('d/m/Y') }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="bg-light p-3 rounded-3 mt-3">
                                                                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Información Adicional</h6>
                                                                <p class="mb-1"><strong>Estado:</strong> {{ $socio->estadoMembresia->nom_estado }}</p>
                                                                <p class="mb-1"><strong>Días restantes:</strong> 
                                                                    {{ now()->diffInDays($socio->fecha_vencimiento, false) }} días
                                                                </p>
                                                            </div>
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

                                    <!-- Modal Editar Socio -->
                                    <div class="modal fade" id="editSocioModal{{ $socio->id_socio }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-edit me-2"></i>Editar Socio
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('socios.update', $socio->id_socio) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Persona</label>
                                                            <select name="id_persona" class="form-select border-2" required>
                                                                <option value="" disabled>Seleccione persona</option>
                                                                @foreach ($personas as $persona)
                                                                    <option value="{{ $persona->id_persona }}" {{ $socio->id_persona == $persona->id_persona ? 'selected' : '' }}>
                                                                        {{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Estado de Membresía</label>
                                                            <select name="id_estado_mem" class="form-select border-2" required>
                                                                <option value="" disabled>Seleccione estado</option>
                                                                @foreach ($estados as $estado)
                                                                    <option value="{{ $estado->id_estado_mem }}" {{ $socio->id_estado_mem == $estado->id_estado_mem ? 'selected' : '' }}>
                                                                        {{ $estado->nom_estado }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Fecha Inscripción</label>
                                                                <input type="date" name="fecha_inscripcion" 
                                                                       value="{{ $socio->fecha_inscripcion->format('Y-m-d') }}" 
                                                                       class="form-control border-2" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Fecha Vencimiento</label>
                                                                <input type="date" name="fecha_vencimiento" 
                                                                       value="{{ $socio->fecha_vencimiento->format('Y-m-d') }}" 
                                                                       class="form-control border-2" required>
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
                        
                        @if(method_exists($socios, 'hasPages') && $socios->hasPages())
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-center">
                                {{ $socios->links() }}
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Socio -->
<div class="modal fade" id="createSocioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Socio
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('socios.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Persona</label>
                        <select name="id_persona" class="form-select border-2" required>
                            <option value="" selected disabled>Seleccione persona</option>
                            @foreach ($personas as $persona)
                                <option value="{{ $persona->id_persona }}">
                                    {{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Estado de Membresía</label>
                        <select name="id_estado_mem" class="form-select border-2" required>
                            <option value="" selected disabled>Seleccione estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado_mem }}">
                                    {{ $estado->nom_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fecha Inscripción</label>
                            <input type="date" name="fecha_inscripcion" 
                                   class="form-control border-2" 
                                   value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fecha Vencimiento</label>
                            <input type="date" name="fecha_vencimiento" 
                                   class="form-control border-2" 
                                   value="{{ now()->addYear()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Registrar Socio
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
                form.action = '/socios/' + id;
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