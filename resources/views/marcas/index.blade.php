@extends('layouts.app')

@section('template_title')
    Gestión de Marcas
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado mejorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-tags me-2"></i> Gestión de Marcas
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Marcas</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-home me-2"></i> Inicio
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMarcaModal">
                <i class="fas fa-plus-circle me-2"></i> Nueva Marca
            </button>
        </div>
    </div>

    <!-- Tarjetas de marcas mejoradas -->
    <div class="row">
        @forelse ($marcas as $marca)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 hover-effect">
                <div class="card-body text-center">
                    <div class="brand-icon mb-3">
                        <i class="fas fa-tag fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3">{{ $marca->nom_marca }}</h5>
                    
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" 
                                data-bs-target="#viewMarcaModal{{ $marca->id_marca }}">
                            <i class="fas fa-eye me-1"></i> Ver
                        </button>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" 
                                data-bs-target="#editMarcaModal{{ $marca->id_marca }}">
                            <i class="fas fa-edit me-1"></i> Editar
                        </button>
                        <!-- Manteniendo tu función de eliminar original -->
                        <form onsubmit="event.preventDefault(); confirmDelete({{ $marca->id_marca }});" style="display: inline;">
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

        <!-- Modal Ver Marca (mejorado) -->
        <div class="modal fade" id="viewMarcaModal{{ $marca->id_marca }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle me-2"></i> Detalles de Marca
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="text-muted mb-0">ID Marca</h6>
                                    <p class="mb-0 fw-bold">{{ $marca->id_marca }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="text-muted mb-0">Nombre</h6>
                                    <p class="mb-0 fw-bold">{{ $marca->nom_marca }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Marca (mejorado) -->
        <div class="modal fade" id="editMarcaModal{{ $marca->id_marca }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-edit me-2"></i> Editar Marca
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('marcas.update', $marca->id_marca) }}" id="editForm{{ $marca->id_marca }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="form-label fw-bold">Nombre de la Marca</label>
                                <input type="text" name="nom_marca" value="{{ $marca->nom_marca }}" 
                                       class="form-control form-control-lg" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </button>
                        <button type="submit" form="editForm{{ $marca->id_marca }}" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tags fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No hay marcas registradas</h4>
                    <p class="text-muted">Comienza agregando una nueva marca</p>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createMarcaModal">
                        <i class="fas fa-plus-circle me-2"></i> Crear Marca
                    </button>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($marcas->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $marcas->links() }}
    </div>
    @endif
</div>

<!-- Modal Crear Marca (mejorado) -->
<div class="modal fade" id="createMarcaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i> Nueva Marca
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('marcas.store') }}" id="createMarcaForm">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nombre de la Marca</label>
                        <input type="text" name="nom_marca" class="form-control form-control-lg" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancelar
                </button>
                <button type="submit" form="createMarcaForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Guardar Marca
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Manteniendo tu script de eliminación original -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar Marca?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/marcas/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('register'))
    <script>
        Swal.fire({
            title: 'Registro exitoso',
            text: 'La marca ha sido creada.',
            icon: 'success',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
@endif
@if(session('modify'))
    <script>
        Swal.fire({
            title: 'Actualización exitosa',
            text: 'La marca ha sido actualizada.',
            icon: 'success',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
@endif
@if(session('destroy'))
    <script>
        Swal.fire({
            title: 'Eliminación exitosa',
            text: 'La marca ha sido eliminada.',
            icon: 'success',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
@endif

@endsection

@section('styles')
<style>
    /* Estilos mejorados */
    .card {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .brand-icon {
        color: var(--bs-primary);
        transition: transform 0.3s ease;
    }
    .card:hover .brand-icon {
        transform: scale(1.1);
    }
    .modal-header {
        padding: 1rem 1.5rem;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0.5rem;
    }
    .btn-outline-primary {
        border-color: var(--bs-primary);
        color: var(--bs-primary);
    }
    .btn-outline-primary:hover {
        background-color: var(--bs-primary);
        color: white;
    }
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>
@endsection