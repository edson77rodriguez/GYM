@extends('layouts.app')

@section('template_title')
    Gestión de Estados de Membresía
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-info text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-id-card-alt me-2"></i>Estados de Membresía</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-light me-2" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Volver al Inicio') }}
                            </button>
                            <button class="btn btn-light text-info fw-bold" data-bs-toggle="modal" data-bs-target="#createEstadoModal">
                                <i class="fas fa-plus-circle me-1"></i> {{ __('Nuevo Estado') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($estadosMembresias->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4 class="fw-bold">No hay estados de membresía registrados</h4>
                            <p class="mb-0">Comienza agregando tu primer estado</p>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach ($estadosMembresias as $estado)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition-all">
                                    <div class="card-body text-center">
                                        <div class="avatar-lg mx-auto mb-3">
                                            @php
                                                $colorClass = [
                                                    'Activo' => 'bg-success',
                                                    'Inactivo' => 'bg-secondary',
                                                    'Suspendido' => 'bg-warning',
                                                    'Vencido' => 'bg-danger'
                                                ][$estado->nom_estado] ?? 'bg-primary';
                                            @endphp
                                            <div class="avatar-title rounded-3 {{ $colorClass }} text-white fs-2">
                                                <i class="fas fa-{{ $estado->nom_estado === 'Activo' ? 'check-circle' : ($estado->nom_estado === 'Inactivo' ? 'times-circle' : 'exclamation-circle') }}"></i>
                                            </div>
                                        </div>
                                        
                                        <h5 class="card-title fw-bold">{{ $estado->nom_estado }}</h5>
                                        <p class="text-muted small">ID: {{ $estado->id_estado_mem }}</p>
                                        
                                        <div class="d-flex justify-content-center gap-2 mt-3">
                                            <button class="btn btn-sm btn-outline-info rounded-pill" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewEstadoModal{{ $estado->id_estado_mem }}">
                                                <i class="fas fa-eye me-1"></i> Ver
                                            </button>
                                            
                                            <button class="btn btn-sm btn-outline-primary rounded-pill" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editEstadoModal{{ $estado->id_estado_mem }}">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </button>
                                            
                                            <form onsubmit="event.preventDefault(); confirmDelete({{ $estado->id_estado_mem }});" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Ver Estado -->
                            <div class="modal fade" id="viewEstadoModal{{ $estado->id_estado_mem }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-info-circle me-2"></i>Detalles del Estado
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                <div class="avatar-lg mx-auto mb-3">
                                                    <div class="avatar-title rounded-3 {{ $colorClass }} text-white fs-2">
                                                        <i class="fas fa-{{ $estado->nom_estado === 'Activo' ? 'check-circle' : ($estado->nom_estado === 'Inactivo' ? 'times-circle' : 'exclamation-circle') }}"></i>
                                                    </div>
                                                </div>
                                                <h4 class="fw-bold">{{ $estado->nom_estado }}</h4>
                                            </div>
                                            
                                            <div class="bg-light p-3 rounded-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="mb-2"><strong>ID:</strong></p>
                                                        <p class="mb-2"><strong>Registrado:</strong></p>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <p class="mb-2">{{ $estado->id_estado_mem }}</p>
                                                        <p class="mb-2">{{ $estado->created_at->format('d/m/Y') }}</p>
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

                            <!-- Modal Editar Estado -->
                            <div class="modal fade" id="editEstadoModal{{ $estado->id_estado_mem }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-edit me-2"></i>Editar Estado
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('estado_membresias.update', $estado->id_estado_mem) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-4 text-center">
                                                    <div class="avatar-lg mx-auto mb-3">
                                                        <div class="avatar-title rounded-3 {{ $colorClass }} text-white fs-2">
                                                            <i class="fas fa-{{ $estado->nom_estado === 'Activo' ? 'check-circle' : ($estado->nom_estado === 'Inactivo' ? 'times-circle' : 'exclamation-circle') }}"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nombre del Estado</label>
                                                    <input type="text" name="nom_estado" value="{{ $estado->nom_estado }}" 
                                                           class="form-control border-2" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> Cancelar
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Guardar Cambios
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                @if(method_exists($estadosMembresias, 'hasPages') && $estadosMembresias->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-center">
                        {{ $estadosMembresias->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Estado -->
<div class="modal fade" id="createEstadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Estado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('estado_membresias.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-4 text-center">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title rounded-3 bg-secondary text-white fs-2">
                                <i class="fas fa-id-card-alt"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold">Crear nuevo estado de membresía</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Estado</label>
                        <input type="text" name="nom_estado" class="form-control border-2" required
                               placeholder="Ej: Activo, Inactivo, Suspendido">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Crear Estado
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
                form.action = '/estado_membresias/' + id;
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

@if(session('register'))
    <script>
        Swal.fire({
            title: '¡Registro exitoso!',
            text: 'El estado de membresía ha sido creado correctamente.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('modify'))
    <script>
        Swal.fire({
            title: '¡Actualización exitosa!',
            text: 'Los datos del estado de membresía han sido actualizados.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('destroy'))
    <script>
        Swal.fire({
            title: '¡Eliminación completada!',
            text: 'El estado de membresía ha sido eliminado del sistema.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@endsection