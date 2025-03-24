@extends('layouts.app')

@section('template_title')
    Empleados
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createEmpleadoModal">
                {{ __('Agregar Nuevo Empleado') }}
            </button>
        </div>
        @foreach ($empleados as $empleado)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}</h5>
                    <p class="card-text"><strong>Disponibilidad:</strong> {{ $empleado->disponibilidad->desc_dispo }}</p>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewEmpleadoModal{{ $empleado->id_empleado }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editEmpleadoModal{{ $empleado->id_empleado }}">Editar</button>
                        <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este empleado?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Empleado -->
        <div class="modal fade" id="viewEmpleadoModal{{ $empleado->id_empleado }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Empleado ID:</strong> {{ $empleado->id_empleado }}</p>
                        <p><strong>Nombre:</strong> {{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}</p>
                        <p><strong>Disponibilidad:</strong> {{ $empleado->disponibilidad->desc_dispo }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Empleado -->
        <div class="modal fade" id="editEmpleadoModal{{ $empleado->id_empleado }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('empleados.update', $empleado->id_empleado) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Persona</label>
                                <select name="id_persona" class="form-select" required>
                                    @foreach ($personas as $persona)
                                        <option value="{{ $persona->id_persona }}" {{ $empleado->id_persona == $persona->id_persona ? 'selected' : '' }}>
                                            {{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Disponibilidad</label>
                                <select name="id_disponibilidad" class="form-select" required>
                                    @foreach ($disponibilidades as $disponibilidad)
                                        <option value="{{ $disponibilidad->id_disponibilidad }}" {{ $empleado->id_disponibilidad == $disponibilidad->id_disponibilidad ? 'selected' : '' }}>
                                            {{ $disponibilidad->desc_dispo }}
                                        </option>
                                    @endforeach
                                </select>
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

<!-- Modal Crear Empleado -->
<div class="modal fade" id="createEmpleadoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('empleados.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Persona</label>
                        <select name="id_persona" class="form-select" required>
                            @foreach ($personas as $persona)
                                <option value="{{ $persona->id_persona }}">{{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Disponibilidad</label>
                        <select name="id_disponibilidad" class="form-select" required>
                            @foreach ($disponibilidades as $disponibilidad)
                                <option value="{{ $disponibilidad->id_disponibilidad }}">{{ $disponibilidad->desc_dispo }}</option>
                            @endforeach
                        </select>
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
            title: '¿Eliminar Empleado?',
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
                form.action = '/empleados/' + id;
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
