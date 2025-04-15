@extends('layouts.app')

@section('template_title')
    Gestión de Equipos del Gimnasio
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-dark text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-dumbbell me-2"></i>Equipos del Gimnasio</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-light me-2" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Volver al Inicio') }}
                            </button>
                            <button class="btn btn-light text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#createEquipoModal">
                                <i class="fas fa-plus-circle me-1"></i> {{ __('Nuevo Equipo') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($equipos->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4 class="fw-bold">No hay equipos registrados</h4>
                            <p class="mb-0">Comienza agregando tu primer equipo</p>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach ($equipos as $equipo)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition-all">
                                    <div class="position-relative">
                                        <img src="{{ $equipo->imagen_equipo ? asset('storage/' . $equipo->imagen_equipo) : asset('img/placeholder-equipment.png') }}" 
                                             class="card-img-top object-fit-cover" 
                                             alt="{{ $equipo->nom_equipo }}"
                                             style="height: 200px; width: 100%;">
                                        <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                            #{{ $equipo->id_equipo }}
                                        </span>
                                    </div>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold text-truncate">{{ $equipo->nom_equipo }}</h5>
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($equipo->desc_equipo, 100) }}
                                        </p>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent border-top-0 pt-0 pb-3">
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewEquipoModal{{ $equipo->id_equipo }}">
                                                <i class="fas fa-eye me-1"></i> Detalles
                                            </button>
                                            
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editEquipoModal{{ $equipo->id_equipo }}">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </button>
                                            
                                            <form onsubmit="event.preventDefault(); confirmDelete({{ $equipo->id_equipo }});" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Ver Equipo -->
                            <div class="modal fade" id="viewEquipoModal{{ $equipo->id_equipo }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-info-circle me-2"></i>Detalles del Equipo
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-5 mb-3 mb-md-0">
                                                    <div class="sticky-top" style="top: 20px;">
                                                        <img src="{{ $equipo->imagen_equipo ? asset('storage/' . $equipo->imagen_equipo) : asset('img/placeholder-equipment.png') }}" 
                                                             class="img-fluid rounded-3 shadow-sm" 
                                                             alt="{{ $equipo->nom_equipo }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <h4 class="fw-bold text-primary">{{ $equipo->nom_equipo }}</h4>
                                                    
                                                    <h5 class="fw-bold mt-4">Descripción:</h5>
                                                    <p class="text-muted">{{ $equipo->desc_equipo }}</p>
                                                    
                                                    <div class="bg-light p-3 rounded-3 mt-4">
                                                        <h6 class="fw-bold mb-3"><i class="fas fa-barcode me-2"></i>Información Técnica</h6>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p class="mb-1"><strong>ID:</strong></p>
                                                                <p class="mb-1"><strong>Registro:</strong></p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="mb-1">{{ $equipo->id_equipo }}</p>
                                                                <p class="mb-1">{{ $equipo->created_at->format('d/m/Y') }}</p>
                                                            </div>
                                                        </div>
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

                            <!-- Modal Editar Equipo -->
                            <div class="modal fade" id="editEquipoModal{{ $equipo->id_equipo }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-edit me-2"></i>Editar Equipo
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('equipos.update', $equipo->id_equipo) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nombre del Equipo</label>
                                                    <input type="text" name="nom_equipo" value="{{ $equipo->nom_equipo }}" 
                                                           class="form-control border-2" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Descripción</label>
                                                    <textarea name="desc_equipo" class="form-control border-2" rows="4">{{ $equipo->desc_equipo }}</textarea>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Imagen del Equipo</label>
                                                    <input type="file" name="imagen_equipo" class="form-control border-2">
                                                    @if ($equipo->imagen_equipo)
                                                        <div class="mt-2 text-center">
                                                            <img src="{{ asset('storage/' . $equipo->imagen_equipo) }}" 
                                                                 class="img-thumbnail" 
                                                                 style="max-height: 150px;">
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input" type="checkbox" name="eliminar_imagen" id="eliminarImagen{{ $equipo->id_equipo }}">
                                                                <label class="form-check-label text-danger" for="eliminarImagen{{ $equipo->id_equipo }}">
                                                                    Eliminar imagen actual
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
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
                        </div>
                    @endif
                </div>
                
                @if(method_exists($equipos, 'hasPages') && $equipos->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-center">
                        {{ $equipos->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Equipo -->
<div class="modal fade" id="createEquipoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Equipo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('equipos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Equipo</label>
                        <input type="text" name="nom_equipo" class="form-control border-2" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="desc_equipo" class="form-control border-2" rows="4"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Imagen del Equipo</label>
                        <input type="file" name="imagen_equipo" class="form-control border-2" required>
                        <small class="text-muted">Formatos: JPG, PNG. Tamaño máximo: 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Registrar Equipo
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
                form.action = '/equipos/' + id;
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
            text: 'El equipo ha sido creado correctamente.',
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
            text: 'Los datos del equipo han sido actualizados.',
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
            text: 'El equipo ha sido eliminado del sistema.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@endsection