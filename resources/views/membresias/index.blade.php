@extends('layouts.app')

@section('template_title')
    Membresías
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
    <div class="col-12 text-center mb-4">
    <h2 class="fw-bold text-uppercase">Membresias</h2>
    </div>
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createMembresiaModal">
                {{ __('Agregar Nueva Membresía') }}
            </button>
        </div>

        <!-- Tabla de membresías -->
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Socio</th>
                        <th>Plan</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($membresias as $membresia)
                        <tr>
                            <td>{{ $membresia->id_membresia }}</td>
                            <td>{{ $membresia->socio->persona->nom }} {{ $membresia->socio->persona->ap }} {{ $membresia->socio->persona->am }}</td>
                            <td>{{ $membresia->plan->nom_plan }}</td>
                            <td>{{ $membresia->fecha_inicio->format('d-m-Y') }}</td>
                            <td>{{ $membresia->fecha_fin->format('d-m-Y') }}</td>
                            <td>{{ $membresia->costo }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewMembresiaModal{{ $membresia->id_membresia }}">Ver</button>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editMembresiaModal{{ $membresia->id_membresia }}">Editar</button>
                                <form action="{{ route('membresias.destroy', $membresia) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta membresía?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>

                            </td>
                        </tr>

                        <!-- Modal Ver Membresía -->
                        <div class="modal fade" id="viewMembresiaModal{{ $membresia->id_membresia }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detalles de la Membresía</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>ID:</strong> {{ $membresia->id_membresia }}</p>
                                        <p><strong>Socio:</strong> {{ $membresia->socio->persona->nom }} {{ $membresia->socio->persona->ap }} {{ $membresia->socio->persona->am }}</p>
                                        <p><strong>Plan:</strong> {{ $membresia->plan->nom_plan }}</p>
                                        <p><strong>Fecha Inicio:</strong> {{ $membresia->fecha_inicio->format('d-m-Y') }}</p>
                                        <p><strong>Fecha Fin:</strong> {{ $membresia->fecha_fin->format('d-m-Y') }}</p>
                                        <p><strong>Costo:</strong> {{ $membresia->costo }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Membresía -->
                        <div class="modal fade" id="editMembresiaModal{{ $membresia->id_membresia }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Membresía</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('membresias.update', $membresia->id_membresia) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Socio</label>
                                                <select name="id_socio" class="form-select" required>
                                                    @foreach ($socios as $socio)
                                                        <option value="{{ $socio->id_socio }}" {{ $membresia->id_socio == $socio->id_socio ? 'selected' : '' }}>{{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Plan</label>
                                                <select name="id_plan" class="form-select" required>
                                                    @foreach ($planes as $plan)
                                                        <option value="{{ $plan->id_plan }}" {{ $membresia->id_plan == $plan->id_plan ? 'selected' : '' }}>{{ $plan->nom_plan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha Inicio</label>
                                                <input type="date" name="fecha_inicio" value="{{ $membresia->fecha_inicio->format('Y-m-d') }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha Fin</label>
                                                <input type="date" name="fecha_fin" value="{{ $membresia->fecha_fin->format('Y-m-d') }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Costo</label>
                                                <input type="number" name="costo" value="{{ $membresia->costo }}" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear Membresía -->
<div class="modal fade" id="createMembresiaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nueva Membresía</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('membresias.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Socio</label>
                        <select name="id_socio" class="form-select" required>
                            @foreach ($socios as $socio)
                                <option value="{{ $socio->id_socio }}">{{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Plan</label>
                        <select name="id_plan" class="form-select" required>
                            @foreach ($planes as $plan)
                                <option value="{{ $plan->id_plan }}">{{ $plan->nom_plan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Costo</label>
                        <input type="number" name="costo" class="form-control" required>
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
            title: '¿Eliminar Membresía?',
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
                form.action = '/membresias/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@if(session('success'))
    <script>Swal.fire('Éxito', '{{ session('success') }}', 'success');</script>
@endif

@endsection
