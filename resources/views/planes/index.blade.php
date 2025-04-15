@extends('layouts.app')

@section('template_title')
    Gestión de Planes de Membresía
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-id-card-alt me-2"></i>Planes de Membresía</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-light me-2" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Volver al Inicio') }}
                            </button>
                            <button class="btn btn-light text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#createPlanModal">
                                <i class="fas fa-plus-circle me-1"></i> {{ __('Nuevo Plan') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($planes->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4 class="fw-bold">No hay planes registrados</h4>
                            <p class="mb-0">Comienza agregando tu primer plan</p>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach ($planes as $plan)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition-all">
                                    <div class="card-body text-center">
                                        <div class="avatar-lg mx-auto mb-3">
                                            <div class="avatar-title rounded-3 bg-primary-light text-primary fs-2">
                                                <i class="fas fa-crown"></i>
                                            </div>
                                        </div>
                                        
                                        <h5 class="card-title fw-bold">{{ $plan->nom_plan }}</h5>
                                        <h4 class="text-success my-3">${{ number_format($plan->costo, 2) }}</h4>
                                        
                                        <p class="card-text text-muted mb-4">
                                            {{ Str::limit($plan->desc_plan, 100) }}
                                        </p>
                                        
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-outline-info rounded-pill" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewPlanModal{{ $plan->id_plan }}">
                                                <i class="fas fa-eye me-1"></i> Detalles
                                            </button>
                                            
                                            <button class="btn btn-sm btn-outline-primary rounded-pill" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editPlanModal{{ $plan->id_plan }}">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </button>
                                            
                                            <form onsubmit="event.preventDefault(); confirmDelete({{ $plan->id_plan }});" 
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

                            <!-- Modal Ver Plan -->
                            <div class="modal fade" id="viewPlanModal{{ $plan->id_plan }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-info-circle me-2"></i>Detalles del Plan
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                <div class="avatar-lg mx-auto mb-3">
                                                    <div class="avatar-title rounded-3 bg-primary-light text-primary fs-2">
                                                        <i class="fas fa-crown"></i>
                                                    </div>
                                                </div>
                                                <h4 class="fw-bold">{{ $plan->nom_plan }}</h4>
                                                <h2 class="text-success my-3">${{ number_format($plan->costo, 2) }}</h2>
                                            </div>
                                            
                                            <h5 class="fw-bold">Descripción:</h5>
                                            <p class="text-muted">{{ $plan->desc_plan }}</p>
                                            
                                            <div class="bg-light p-3 rounded-3 mt-4">
                                                <h6 class="fw-bold mb-3"><i class="fas fa-barcode me-2"></i>Información Técnica</h6>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="mb-1"><strong>ID:</strong></p>
                                                        <p class="mb-1"><strong>Registrado:</strong></p>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <p class="mb-1">{{ $plan->id_plan }}</p>
                                                        <p class="mb-1">{{ $plan->created_at ? $plan->created_at->format('d/m/Y') : '' }}</p>                                                    </div>
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

                            <!-- Modal Editar Plan -->
                            <div class="modal fade" id="editPlanModal{{ $plan->id_plan }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-edit me-2"></i>Editar Plan
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('planes.update', $plan->id_plan) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-4 text-center">
                                                    <div class="avatar-lg mx-auto mb-3">
                                                        <div class="avatar-title rounded-3 bg-primary-light text-primary fs-2">
                                                            <i class="fas fa-crown"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nombre del Plan</label>
                                                    <input type="text" name="nom_plan" value="{{ $plan->nom_plan }}" 
                                                           class="form-control border-2" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Descripción</label>
                                                    <textarea name="desc_plan" class="form-control border-2" rows="4" required>{{ $plan->desc_plan }}</textarea>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Costo Mensual</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" name="costo" value="{{ $plan->costo }}" 
                                                               class="form-control border-2" min="0" step="0.01" required>
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
                        </div>
                    @endif
                </div>
                
                @if(method_exists($planes, 'hasPages') && $planes->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-center">
                        {{ $planes->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Plan -->
<div class="modal fade" id="createPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Plan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('planes.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-4 text-center">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title rounded-3 bg-primary-light text-primary fs-2">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold">Crear nuevo plan de membresía</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Plan</label>
                        <input type="text" name="nom_plan" class="form-control border-2" required
                               placeholder="Ej: Plan Básico, Plan Premium">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="desc_plan" class="form-control border-2" rows="4" required
                                  placeholder="Incluya los beneficios del plan"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Costo Mensual</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="costo" class="form-control border-2" 
                                   min="0" step="0.01" required placeholder="0.00">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Crear Plan
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
                form.action = '/planes/' + id;
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
            title: '¡Operación exitosa!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    </script>
@endif

@endsection

@section('styles')
<style>
    .bg-primary-light {
        background-color: rgba(78, 115, 223, 0.1);
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .border-2 {
        border-width: 2px !important;
    }
    
    .rounded-pill {
        border-radius: 50rem !important;
    }
    
    .hover-shadow-lg:hover {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
</style>
@endsection