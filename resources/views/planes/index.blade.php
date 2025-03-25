@extends('layouts.app')

@section('template_title')
    Planes
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
    <div class="col-12 text-center mb-4">
    <h2 class="fw-bold text-uppercase">Planes</h2>
    </div>
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createPlanModal">
                {{ __('Agregar Nuevo Plan') }}
            </button>
        </div>
        @foreach ($planes as $plan)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $plan->nom_plan }}</h5>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewPlanModal{{ $plan->id_plan }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPlanModal{{ $plan->id_plan }}">Editar</button>
                        <form onsubmit="event.preventDefault(); confirmDelete({{ $plan->id_plan }});" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Plan -->
        <div class="modal fade" id="viewPlanModal{{ $plan->id_plan }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $plan->id_plan }}</p>
                        <p><strong>Nombre del Plan:</strong> {{ $plan->nom_plan }}</p>
                        <p><strong>Descripción:</strong> {{ $plan->desc_plan }}</p>
                        <p><strong>Costo:</strong> ${{ number_format($plan->costo, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Plan -->
        <div class="modal fade" id="editPlanModal{{ $plan->id_plan }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('planes.update', $plan->id_plan) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nombre del Plan</label>
                                <input type="text" name="nom_plan" value="{{ $plan->nom_plan }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="desc_plan" class="form-control" required>{{ $plan->desc_plan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Costo</label>
                                <input type="number" name="costo" value="{{ $plan->costo }}" class="form-control" required min="0" step="0.01">
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>

<!-- Modal Crear Plan -->
<div class="modal fade" id="createPlanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('planes.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre del Plan</label>
                        <input type="text" name="nom_plan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="desc_plan" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Costo</label>
                        <input type="number" name="costo" class="form-control" required min="0" step="0.01">
                    </div>
                    <button type="submit" class="btn btn-success">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar Plan?',
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
                form.action = '/planes/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>Swal.fire('Operación exitosa', '{{ session('success') }}', 'success');</script>
@endif

@endsection
