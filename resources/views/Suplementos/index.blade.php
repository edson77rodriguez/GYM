@extends('layouts.app')

@section('template_title')
    Gestión de Suplementos
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-dark text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-capsules me-2"></i>Catálogo de Suplementos</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-light me-2" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Volver al Inicio') }}
                            </button>
                            <button class="btn btn-light text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#createSuplementoModal">
                                <i class="fas fa-plus-circle me-1"></i> {{ __('Nuevo Suplemento') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($suplementos->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4 class="fw-bold">No hay suplementos registrados</h4>
                            <p class="mb-0">Comienza agregando tu primer suplemento</p>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach ($suplementos as $suplemento)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition-all">
                                    <div class="position-relative">
                                        <img src="{{ $suplemento->imagen_suplemento ? asset('storage/' . $suplemento->imagen_suplemento) : asset('img/placeholder-product.png') }}" 
                                             class="card-img-top object-fit-cover" 
                                             alt="{{ $suplemento->nom_suplemento }}"
                                             style="height: 200px; width: 100%;">
                                        <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                            {{ $suplemento->stock }} disponibles
                                        </span>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fw-bold text-truncate">{{ $suplemento->nom_suplemento }}</h5>
                                            <span class="badge bg-success fs-6">${{ number_format($suplemento->precio, 2) }}</span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <span class="badge bg-info text-dark me-1">
                                                <i class="fas fa-tag me-1"></i> {{ $suplemento->categoria->nom_cat }}
                                            </span>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-industry me-1"></i> {{ $suplemento->marca->nom_marca }}
                                            </span>
                                        </div>
                                        
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($suplemento->desc_suplemento, 120) }}
                                        </p>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent border-top-0 pt-0 pb-3">
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewSuplementoModal{{ $suplemento->id_suplemento }}">
                                                <i class="fas fa-eye me-1"></i> Detalles
                                            </button>
                                            
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editSuplementoModal{{ $suplemento->id_suplemento }}">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </button>
                                            
                                            <form onsubmit="event.preventDefault(); confirmDelete({{ $suplemento->id_suplemento }});" 
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

                            <!-- Modal Ver Suplemento -->
                            <div class="modal fade" id="viewSuplementoModal{{ $suplemento->id_suplemento }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-info-circle me-2"></i>Detalles del Suplemento
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-5 mb-3 mb-md-0">
                                                    <div class="sticky-top" style="top: 20px;">
                                                        <img src="{{ $suplemento->imagen_suplemento ? asset('storage/' . $suplemento->imagen_suplemento) : asset('img/placeholder-product.png') }}" 
                                                             class="img-fluid rounded-3 shadow-sm" 
                                                             alt="{{ $suplemento->nom_suplemento }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <h4 class="fw-bold text-primary">{{ $suplemento->nom_suplemento }}</h4>
                                                    
                                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                                        <span class="badge bg-info text-dark">
                                                            <i class="fas fa-tag me-1"></i> {{ $suplemento->categoria->nom_cat }}
                                                        </span>
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-industry me-1"></i> {{ $suplemento->marca->nom_marca }}
                                                        </span>
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-dollar-sign me-1"></i> ${{ number_format($suplemento->precio, 2) }}
                                                        </span>
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-cubes me-1"></i> {{ $suplemento->stock }} unidades
                                                        </span>
                                                    </div>
                                                    
                                                    <h5 class="fw-bold mt-4">Descripción:</h5>
                                                    <p class="text-muted">{{ $suplemento->desc_suplemento }}</p>
                                                    
                                                    <div class="bg-light p-3 rounded-3 mt-4">
                                                        <h6 class="fw-bold mb-3"><i class="fas fa-barcode me-2"></i>Información Técnica</h6>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p class="mb-1"><strong>ID:</strong></p>
                                                                <p class="mb-1"><strong>Registro:</strong></p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="mb-1">{{ $suplemento->id_suplemento }}</p>
                                                                <p class="mb-1">{{ $suplemento->created_at->format('d/m/Y') }}</p>
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

                            <!-- Modal Editar Suplemento -->
                            <div class="modal fade" id="editSuplementoModal{{ $suplemento->id_suplemento }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-edit me-2"></i>Editar Suplemento
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('suplementos.update', $suplemento->id_suplemento) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nombre del Suplemento</label>
                                                    <input type="text" name="nom_suplemento" value="{{ $suplemento->nom_suplemento }}" 
                                                           class="form-control border-2" required>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Categoría</label>
                                                        <select name="id_categoria" class="form-select border-2" required>
                                                            <option value="" disabled>Seleccione categoría</option>
                                                            @foreach ($categorias as $categoria)
                                                                <option value="{{ $categoria->id_categoria }}" {{ $suplemento->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                                                                    {{ $categoria->nom_cat }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Marca</label>
                                                        <select name="id_marca" class="form-select border-2" required>
                                                            <option value="" disabled>Seleccione marca</option>
                                                            @foreach ($marcas as $marca)
                                                                <option value="{{ $marca->id_marca }}" {{ $suplemento->id_marca == $marca->id_marca ? 'selected' : '' }}>
                                                                    {{ $marca->nom_marca }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Descripción</label>
                                                    <textarea name="desc_suplemento" class="form-control border-2" rows="3">{{ $suplemento->desc_suplemento }}</textarea>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Precio ($)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" name="precio" value="{{ $suplemento->precio }}" 
                                                                   class="form-control border-2" step="0.01" min="0" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Stock</label>
                                                        <input type="number" name="stock" value="{{ $suplemento->stock }}" 
                                                               class="form-control border-2" min="0" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Imagen del Producto</label>
                                                    <input type="file" name="imagen_suplemento" class="form-control border-2">
                                                    <small class="text-muted">Dejar en blanco para mantener la imagen actual</small>
                                                </div>
                                                
                                                <div class="text-center mt-2">
                                                    <div class="form-check form-switch d-inline-block">
                                                        <input class="form-check-input" type="checkbox" id="featuredSwitch">
                                                        <label class="form-check-label" for="featuredSwitch">Destacar producto</label>
                                                    </div>
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
                
                @if($suplementos->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-center">
                        {{ $suplementos->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Suplemento -->
<div class="modal fade" id="createSuplementoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Suplemento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('suplementos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Suplemento</label>
                        <input type="text" name="nom_suplemento" class="form-control border-2" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Categoría</label>
                            <select name="id_categoria" class="form-select border-2" required>
                                <option value="" selected disabled>Seleccione categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nom_cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Marca</label>
                            <select name="id_marca" class="form-select border-2" required>
                                <option value="" selected disabled>Seleccione marca</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id_marca }}">{{ $marca->nom_marca }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="desc_suplemento" class="form-control border-2" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Precio ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="precio" class="form-control border-2" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stock Inicial</label>
                            <input type="number" name="stock" class="form-control border-2" min="0" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Imagen del Producto</label>
                        <input type="file" name="imagen_suplemento" class="form-control border-2" required>
                        <small class="text-muted">Formatos: JPG, PNG. Tamaño máximo: 2MB</small>
                    </div>
                    
                    <div class="text-center mt-2">
                        <div class="form-check form-switch d-inline-block">
                            <input class="form-check-input" type="checkbox" id="newFeaturedSwitch">
                            <label class="form-check-label" for="newFeaturedSwitch">Destacar producto</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Crear Suplemento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id_suplemento) {
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
                form.action = '/suplementos/' + id_suplemento;
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
            text: 'El suplemento ha sido creado correctamente.',
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
            text: 'Los datos del suplemento han sido actualizados.',
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
            text: 'El suplemento ha sido eliminado del sistema.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@endsection