@extends('layouts.app')

@section('template_title')
    Gestión de Categorías
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado mejorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-tags me-2"></i> Gestión de Categorías
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Categorías</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-home me-2"></i> Inicio
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoriaModal">
                <i class="fas fa-plus-circle me-2"></i> Nueva Categoría
            </button>
        </div>
    </div>

    <!-- Tarjetas de categorías mejoradas -->
    <div class="row">
        @forelse ($categorias as $categoria)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title fw-bold mb-0 text-truncate">
                            <i class="fas fa-tag text-primary me-2"></i>{{ $categoria->nom_cat }}
                        </h5>
                        <span class="badge bg-light text-dark">#{{ $categoria->id_categoria }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" 
                                data-bs-target="#viewCategoriaModal{{ $categoria->id_categoria }}">
                            <i class="fas fa-eye me-1"></i> Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" 
                                data-bs-target="#editCategoriaModal{{ $categoria->id_categoria }}">
                            <i class="fas fa-edit me-1"></i> Editar
                        </button>
                        <form class="d-inline delete-form" action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                    data-id="{{ $categoria->id_categoria }}"
                                    data-name="{{ $categoria->nom_cat }}"
                                    title="Eliminar">
                                <i class="fas fa-trash-alt me-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Categoría -->
        <div class="modal fade" id="viewCategoriaModal{{ $categoria->id_categoria }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle me-2"></i> Detalles de Categoría
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="text-muted mb-0">ID Categoría</h6>
                                    <p class="mb-0 fw-bold">{{ $categoria->id_categoria }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="text-muted mb-0">Nombre</h6>
                                    <p class="mb-0 fw-bold">{{ $categoria->nom_cat }}</p>
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

        <!-- Modal Editar Categoría -->
        <div class="modal fade" id="editCategoriaModal{{ $categoria->id_categoria }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-edit me-2"></i> Editar Categoría
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('categorias.update', $categoria->id_categoria) }}" id="editForm{{ $categoria->id_categoria }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="form-label fw-bold">Nombre de la Categoría</label>
                                <input type="text" name="nom_cat" value="{{ $categoria->nom_cat }}" 
                                       class="form-control form-control-lg" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </button>
                        <button type="submit" form="editForm{{ $categoria->id_categoria }}" class="btn btn-primary">
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
                    <h4 class="text-muted">No hay categorías registradas</h4>
                    <p class="text-muted">Comienza agregando una nueva categoría</p>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createCategoriaModal">
                        <i class="fas fa-plus-circle me-2"></i> Crear Categoría
                    </button>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($categorias->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $categorias->links() }}
    </div>
    @endif
</div>

<!-- Modal Crear Categoría -->
<div class="modal fade" id="createCategoriaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i> Nueva Categoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('categorias.store') }}" id="createCategoriaForm">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nombre de la Categoría</label>
                        <input type="text" name="nom_cat" class="form-control form-control-lg" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancelar
                </button>
                <button type="submit" form="createCategoriaForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Guardar Categoría
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminación -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Configuración global de SweetAlert
        const swalWithBootstrap = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger mx-2',
                cancelButton: 'btn btn-secondary mx-2'
            },
            buttonsStyling: false,
            allowOutsideClick: false
        });

        // Manejar clic en botones de eliminar
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const categoriaId = $(this).data('id');
            const categoriaName = $(this).data('name');
            
            swalWithBootstrap.fire({
                title: '¿Eliminar categoría?',
                html: `Estás a punto de eliminar la categoría: <strong>${categoriaName}</strong><br><span class="text-danger">Esta acción no se puede deshacer</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
                cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                reverseButtons: true,
                backdrop: `
                    rgba(0,0,0,0.7)
                    url("{{ asset('img/trash-animation.gif') }}")
                    left top
                    no-repeat
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loader mientras se procesa
                    swalWithBootstrap.fire({
                        title: 'Eliminando...',
                        html: 'Por favor espere',
                        timer: 1500,
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        // Mostrar notificaciones de sesión
        @if(session('success'))
            showToast('Éxito', '{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            showToast('Error', '{{ session('error') }}', 'error');
        @endif
    });

    function showToast(title, message, type) {
        const toastEl = document.getElementById('liveToast');
        const toast = new bootstrap.Toast(toastEl);
        
        // Configurar el toast
        $('#toast-title').text(title);
        $('#toast-message').text(message);
        $('#toast-time').text(new Date().toLocaleTimeString());
        
        // Cambiar colores según el tipo
        const toastHeader = $('#liveToast .toast-header');
        toastHeader.removeClass('bg-primary bg-success bg-danger bg-warning');
        
        const bgClass = {
            'success': 'bg-success',
            'error': 'bg-danger',
            'warning': 'bg-warning'
        }[type] || 'bg-primary';
        
        toastHeader.addClass(bgClass);
        toast.show();
    }
</script>
@endsection