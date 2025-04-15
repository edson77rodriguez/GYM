@extends('layouts.app')

@section('template_title')
    Registrar Nuevo Equipo
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="mb-0">
                            <i class="fas fa-dumbbell me-2"></i>Nuevo Equipo de Gimnasio
                        </h3>
                        <a href="{{ route('equipos.index') }}" class="btn btn-outline-light rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form id="equipoForm" method="POST" action="{{ route('equipos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Nombre del Equipo -->
                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-bold text-primary">
                                <i class="fas fa-cogs me-2"></i>Nombre del Equipo
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 rounded-end" 
                                       id="nombre" name="nombre" placeholder="Ej: Prensa de piernas, Bicicleta estática..."
                                       required>
                            </div>
                            <div class="form-text text-muted small">Ingrese el nombre comercial del equipo</div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold text-primary">
                                <i class="fas fa-align-left me-2"></i>Descripción
                            </label>
                            <textarea class="form-control" id="descripcion" name="descripcion" 
                                      rows="4" placeholder="Describa las características del equipo..."
                                      required></textarea>
                            <div class="form-text text-muted small">Incluya detalles como marca, modelo y función principal</div>
                        </div>

                        <!-- Categoría -->
                        <div class="mb-4">
                            <label for="categoria" class="form-label fw-bold text-primary">
                                <i class="fas fa-tags me-2"></i>Categoría
                            </label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="" selected disabled>Seleccione una categoría</option>
                                <option value="cardio">Cardio</option>
                                <option value="fuerza">Fuerza</option>
                                <option value="funcional">Funcional</option>
                                <option value="peso_libre">Peso Libre</option>
                            </select>
                        </div>

                        <!-- Estado -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">
                                <i class="fas fa-check-circle me-2"></i>Estado del Equipo
                            </label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="estado" id="disponible" value="disponible" checked>
                                <label class="btn btn-outline-success" for="disponible">
                                    <i class="fas fa-check me-1"></i> Disponible
                                </label>

                                <input type="radio" class="btn-check" name="estado" id="mantenimiento" value="mantenimiento">
                                <label class="btn btn-outline-warning" for="mantenimiento">
                                    <i class="fas fa-tools me-1"></i> Mantenimiento
                                </label>

                                <input type="radio" class="btn-check" name="estado" id="inactivo" value="inactivo">
                                <label class="btn btn-outline-danger" for="inactivo">
                                    <i class="fas fa-times me-1"></i> Inactivo
                                </label>
                            </div>
                        </div>

                        <!-- Imagen -->
                        <div class="mb-4">
                            <label for="imagen" class="form-label fw-bold text-primary">
                                <i class="fas fa-image me-2"></i>Imagen del Equipo
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" class="form-control" id="imagen" name="imagen" 
                                       accept="image/*" onchange="previewImage(event)">
                                <div class="form-text text-muted small">Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                                <div id="imagePreview" class="mt-3 text-center d-none">
                                    <img id="preview" class="img-thumbnail rounded-3" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Adquisición -->
                        <div class="mb-4">
                            <label for="fecha_adquisicion" class="form-label fw-bold text-primary">
                                <i class="fas fa-calendar-alt me-2"></i>Fecha de Adquisición
                            </label>
                            <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-eraser me-1"></i> Limpiar
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save me-1"></i> Registrar Equipo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            previewContainer.classList.add('d-none');
        }
    }

    // Validación del formulario
    document.getElementById('equipoForm').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();
        
        if (!nombre || !descripcion) {
            e.preventDefault();
            Swal.fire({
                title: 'Campos requeridos',
                text: 'Por favor complete todos los campos obligatorios',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
            });
        }
    });
</script>
@endsection

@section('styles')
<style>
    .card {
        border: none;
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .card-header {
        border-radius: 0 !important;
    }
    
    .form-control, .form-select {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .btn-group .btn {
        border-radius: 0.5rem !important;
        margin: 0 2px;
    }
    
    .file-upload-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .img-thumbnail {
        border: 2px dashed #dee2e6;
        padding: 0.25rem;
        background-color: #f8f9fa;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .text-primary {
        color: #4e73df !important;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
</style>
@endsection