@extends('layouts.app')

@section('template_title')
    Mantenimientos
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
    <div class="col-12 text-center mb-4">
    <h2 class="fw-bold text-uppercase">Mantenimientos</h2>
    </div>
        <div class="col-12 text-end mb-3">

            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createMantenimientoModal">
                {{ __('Agregar Nuevo Mantenimiento') }}
            </button>
        </div>

        <!-- Tabla de mantenimientos -->
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipo</th>
                        <th>Empleado</th>
                        <th>Fecha Programada</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mantenimientos as $mantenimiento)
                        <tr>
                            <td>{{ $mantenimiento->id }}</td>
                            <td>{{ $mantenimiento->equipo->nom_equipo }}</td>
                            <td>{{ $mantenimiento->empleado->persona->nom }} {{ $mantenimiento->empleado->persona->ap }} {{ $mantenimiento->empleado->persona->am }}</td>
                            <td>{{ $mantenimiento->fecha_programada }}</td>
                            <td>{{ $mantenimiento->desc_estado }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewMantenimientoModal{{ $mantenimiento->id_mantenimiento }}">Ver</button>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editMantenimientoModal{{ $mantenimiento->id_mantenimiento }}">Editar</button>
                                <form action="{{ route('mantenimientos.destroy', $mantenimiento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este mantenimiento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>

                            </td>
                        </tr>

                        <!-- Modal Ver Mantenimiento -->
                        <div class="modal fade" id="viewMantenimientoModal{{ $mantenimiento->id_mantenimiento }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detalles del Mantenimiento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>ID:</strong> {{ $mantenimiento->id }}</p>
                                        <p><strong>Equipo:</strong> {{ $mantenimiento->equipo->nom_equipo }}</p>
                                        <p><strong>Empleado:</strong> {{ $mantenimiento->empleado->persona->nom }} {{ $mantenimiento->empleado->persona->ap }} {{ $mantenimiento->empleado->persona->am }}</p>
                                        <p><strong>Fecha Programada:</strong> {{ $mantenimiento->fecha_programada }}</p>
                                        <p><strong>Estado:</strong> {{ $mantenimiento->desc_estado }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Mantenimiento -->
                        <div class="modal fade" id="editMantenimientoModal{{ $mantenimiento->id_mantenimiento }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Mantenimiento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('mantenimientos.update', $mantenimiento->id_mantenimiento) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Equipo</label>
                                                <select name="id_equipo" class="form-select" required>
                                                <option value="">Selecciona un equipo</option>
                                                    @foreach ($equipos as $equipo)
                                                        <option value="{{ $equipo->id_equipo }}" {{ $mantenimiento->id_equipo == $equipo->id_mantenimiento ? 'selected' : '' }}>{{ $equipo->nom_equipo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Empleado</label>
                                                <select name="id_empleado" class="form-select" required>
                                                <option value="">Selecciona un empleado</option>

                                                    @foreach ($empleados as $empleado)
                                                        <option value="{{ $empleado->id_empleado }}" {{ $mantenimiento->id_empleado == $empleado->id_mantenimiento ? 'selected' : '' }}>{{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha Programada</label>
                                                <input type="date" name="fecha_programada" value="{{ $mantenimiento->fecha_programada }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Descripción Estado</label>
                                                <input type="text" name="desc_estado" value="{{ $mantenimiento->desc_estado }}" class="form-control">
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

<!-- Modal Crear Mantenimiento -->
<!-- Modal Crear Mantenimiento -->
<div class="modal fade" id="createMantenimientoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('mantenimientos.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="id_equipo" class="form-label">Equipo</label>
                        <select name="id_equipo" id="id_equipo" class="form-select" required>
                        <option value="">Selecciona un equipo</option>
                        @foreach ($equipos as $equipo)
                            <option value="{{ $equipo->id_equipo }}">{{ $equipo->nom_equipo }}</option>
                        @endforeach
                    </select>

                    </div>
                    <div class="mb-3">
                        <label for="id_empleado" class="form-label">Empleado</label>
                        <select name="id_empleado" id="id_empleado" class="form-select" required>
                            <option value="" disabled selected>Selecciona un Empleado encargado</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}">{{ $empleado->persona->nom }} {{ $empleado->persona->ap }} {{ $empleado->persona->am }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Programada</label>
                        <input type="date" name="fecha_programada" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción Estado</label>
                        <input type="text" name="desc_estado" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
function confirmDelete(id_mantenimiento) {
    Swal.fire({
        title: '¿Eliminar Mantenimiento?',
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
            form.method = 'POST';  // Usamos POST porque Laravel lo convierte en DELETE
            form.action = '/mantenimientos/' + id_mantenimiento;  // La ruta de eliminación

            // Agregar el campo _method para indicar que es un DELETE
            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            // Agregar el campo _token con el token CSRF
            let csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = '{{ csrf_token() }}';
            form.appendChild(csrfField);

            // Agregar el formulario al body y enviarlo
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
