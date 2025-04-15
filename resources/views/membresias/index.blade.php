@extends('layouts.app')

@section('template_title')
    Gestión de Membresías
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-success text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-id-card me-2"></i>Membresías Registradas</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-light me-2" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-arrow-left me-1"></i> Volver al Inicio
                            </button>
                            <button class="btn btn-light text-success fw-bold" data-bs-toggle="modal" data-bs-target="#createMembresiaModal">
                                <i class="fas fa-plus-circle me-1"></i> Nueva Membresía
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($membresias->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4 class="fw-bold">No hay membresías registradas</h4>
                            <p class="mb-0">Comienza agregando tu primera membresía</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Socio</th>
                                        <th>Plan</th>
                                        <th class="text-center">Fecha Inicio</th>
                                        <th class="text-center">Fecha Fin</th>
                                        <th class="text-center">Costo</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($membresias as $membresia)
                                    @php
                                    $hoy = now();
                                    $fechaFin = \Carbon\Carbon::parse($membresia->fecha_fin);
                                    
                                    if ($fechaFin->isPast()) {
                                        $estadoClass = 'danger';
                                        $estadoText = 'Vencida';
                                    } elseif ($hoy->diffInDays($fechaFin) < 7) {
                                        $estadoClass = 'warning';
                                        $estadoText = 'Por Vencer';
                                    } else {
                                        $estadoClass = 'success';
                                        $estadoText = 'Activa';
                                    }
                                @endphp
                                        <tr class="hover-shadow">
                                            <td class="text-center fw-bold">{{ $membresia->id_membresia }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-light rounded-circle text-success fw-bold">
                                                            {{ substr($membresia->socio->persona->nom, 0, 1) }}{{ substr($membresia->socio->persona->ap, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $membresia->socio->persona->nom }} {{ $membresia->socio->persona->ap }}</h6>
                                                        <small class="text-muted">ID: {{ $membresia->socio->id_socio }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $membresia->plan->nom_plan }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-calendar-day me-1 text-success"></i> 
                                                    {{ $membresia->fecha_inicio?->format('d/m/Y') ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $estadoClass }}-light text-{{ $estadoClass }}">
                                                    <i class="fas fa-calendar-times me-1"></i> 
                                                    {{ $membresia->fecha_fin?->format('d/m/Y') ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-center fw-bold text-success">${{ number_format($membresia->costo, 2) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $estadoClass }} rounded-pill">
                                                    {{ $estadoText }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-outline-info rounded-circle" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#viewMembresiaModal{{ $membresia->id_membresia }}"
                                                            title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    <button class="btn btn-sm btn-outline-primary rounded-circle" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editMembresiaModal{{ $membresia->id_membresia }}"
                                                            title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    
                                                    <form onsubmit="event.preventDefault(); confirmDelete({{ $membresia->id_membresia }});" 
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

                                        <!-- Modal Ver Membresía -->
                                        <div class="modal fade" id="viewMembresiaModal{{ $membresia->id_membresia }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-id-card me-2"></i>Detalles de la Membresía
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <h6 class="fw-bold text-muted">ID Membresía:</h6>
                                                                <p>{{ $membresia->id_membresia }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <h6 class="fw-bold text-muted">Fecha Registro:</h6>
                                                                <p>{{ $membresia->created_at->format('d/m/Y H:i') }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <h6 class="fw-bold text-muted">Socio:</h6>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm me-2">
                                                                        <div class="avatar-title bg-light rounded-circle text-success">
                                                                            {{ substr($membresia->socio->persona->nom, 0, 1) }}{{ substr($membresia->socio->persona->ap, 0, 1) }}
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0">{{ $membresia->socio->persona->nom }} {{ $membresia->socio->persona->ap }} {{ $membresia->socio->persona->am }}</p>
                                                                        <small class="text-muted">ID: {{ $membresia->socio->id_socio }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <h6 class="fw-bold text-muted">Plan:</h6>
                                                                <p>{{ $membresia->plan->nom_plan }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <h6 class="fw-bold text-muted">Fecha Inicio:</h6>
                                                                <p>
                                                                    <i class="fas fa-calendar-day me-1 text-success"></i> 
                                                                    {{ $membresia->fecha_inicio?->format('d/m/Y') ?? 'N/A' }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <h6 class="fw-bold text-muted">Fecha Fin:</h6>
                                                                <p class="text-{{ $estadoClass }}">
                                                                    <i class="fas fa-calendar-times me-1"></i> 
                                                                    {{ $membresia->fecha_fin?->format('d/m/Y') ?? 'N/A' }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <h6 class="fw-bold text-muted">Costo:</h6>
                                                                <p class="fw-bold text-success">${{ number_format($membresia->costo, 2) }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="bg-light p-3 rounded-3 mt-3">
                                                            <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Estado Actual</h6>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="badge bg-{{ $estadoClass }} rounded-pill fs-6">
                                                                    {{ $estadoText }}
                                                                </span>
                                                                @unless($fechaFin->isPast())
                                                                <small class="text-muted">
                                                                    {{ $hoy->diffInDays($fechaFin) }} días restantes
                                                                </small>
                                                                @endunless
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

                                        <!-- Modal Editar Membresía -->
                                        <div class="modal fade" id="editMembresiaModal{{ $membresia->id_membresia }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-edit me-2"></i>Editar Membresía
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('membresias.update', $membresia->id_membresia) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Socio</label>
                                                                <select name="id_socio" class="form-select border-2" required>
                                                                    <option value="" disabled>Seleccione socio</option>
                                                                    @foreach ($socios as $socio)
                                                                        <option value="{{ $socio->id_socio }}" @selected($membresia->id_socio == $socio->id_socio)>
                                                                            {{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Plan</label>
                                                                <select name="id_plan" class="form-select border-2" required>
                                                                    <option value="" disabled>Seleccione plan</option>
                                                                    @foreach ($planes as $plan)
                                                                        <option value="{{ $plan->id_plan }}" @selected($membresia->id_plan == $plan->id_plan)>
                                                                            {{ $plan->nom_plan }} - ${{ number_format($plan->costo, 2) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Fecha Inicio</label>
                                                                    <input type="date" name="fecha_inicio" 
                                                                           value="{{ $membresia->fecha_inicio?->format('Y-m-d') }}" 
                                                                           class="form-control border-2" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Fecha Fin</label>
                                                                    <input type="date" name="fecha_fin" 
                                                                           value="{{ $membresia->fecha_fin?->format('Y-m-d') }}" 
                                                                           class="form-control border-2" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Costo</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">$</span>
                                                                    <input type="number" name="costo" value="{{ $membresia->costo }}" 
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
                                </tbody>
                            </table>
                        </div>
                        
                        @if(method_exists($membresias, 'hasPages') && $membresias->hasPages())
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-center">
                                {{ $membresias->links() }}
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Membresía -->
<div class="modal fade" id="createMembresiaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Nueva Membresía
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('membresias.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Socio</label>
                        <select name="id_socio" class="form-select border-2" required>
                            <option value="" selected disabled>Seleccione socio</option>
                            @foreach ($socios as $socio)
                                <option value="{{ $socio->id_socio }}">
                                    {{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Plan</label>
                        <select name="id_plan" id="id_plan" class="form-select border-2" required>
                            <option value="" selected disabled>Seleccione plan</option>
                            @foreach ($planes as $plan)
                                <option value="{{ $plan->id_plan }}" data-costo="{{ $plan->costo }}">
                                    {{ $plan->nom_plan }} - ${{ number_format($plan->costo, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" 
                                   class="form-control border-2" 
                                   value="{{ date('Y-m-d') }}" 
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fecha Fin</label>
                            <input type="date" name="fecha_fin" 
                                   class="form-control border-2" 
                                   min="{{ date('Y-m-d') }}" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Costo</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="costo" id="costo" class="form-control border-2" 
                                   min="0" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Registrar Membresía
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
                form.action = '/membresias/' + id;
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Actualizar automáticamente el costo cuando se selecciona un plan
    document.getElementById('id_plan').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const costo = selectedOption.getAttribute('data-costo');
        if (costo) {
            document.getElementById('costo').value = costo;
        }
    });
</script>

@if(session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
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
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
    }
    
    .hover-shadow {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .border-2 {
        border-width: 2px !important;
    }
    
    .rounded-circle {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection