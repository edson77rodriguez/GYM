@extends('layouts.app')

@section('template_title')
    Asistencias
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createAsistenciaModal">
                {{ __('Registrar Asistencia') }}
            </button>
        </div>
        @foreach ($asistencias as $asistencia)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $asistencia->socio->nombre }} {{ $asistencia->socio->apellido }}</h5>
                    <p class="card-text"><strong>Fecha:</strong> {{ $asistencia->fecha_asi }}</p>
                    <p class="card-text"><strong>Hora Entrada:</strong> {{ $asistencia->hora_entrada }}</p>
                    <p class="card-text"><strong>Hora Salida:</strong> {{ $asistencia->hora_salida ?? 'No registrada' }}</p>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewAsistenciaModal{{ $asistencia->id_asistencia }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAsistenciaModal{{ $asistencia->id_asistencia }}">Editar</button>
                        <form onsubmit="event.preventDefault(); confirmDelete({{ $asistencia->id_asistencia }});" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Asistencia -->
        <div class="modal fade" id="viewAsistenciaModal{{ $asistencia->id_asistencia }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles de la Asistencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Socio:</strong> {{ $asistencia->socio->nombre }} {{ $asistencia->socio->apellido }}</p>
                        <p><strong>Fecha:</strong> {{ $asistencia->fecha_asi }}</p>
                        <p><strong>Hora Entrada:</strong> {{ $asistencia->hora_entrada }}</p>
                        <p><strong>Hora Salida:</strong> {{ $asistencia->hora_salida ?? 'No registrada' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Asistencia -->
        <div class="modal fade" id="editAsistenciaModal{{ $asistencia->id_asistencia }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Asistencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('asistencias.update', $asistencia->id_asistencia) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Socio</label>
                                <select name="id_socio" class="form-select" required>
                                    @foreach ($socios as $socio)
                                        <option value="{{ $socio->id_socio }}" {{ $asistencia->id_socio == $socio->id_socio ? 'selected' : '' }}>
                                            {{ $socio->nombre }} {{ $socio->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" name="fecha_asi" class="form-control" value="{{ $asistencia->fecha_asi }}" required>
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

<!-- Modal Crear Asistencia -->
<div class="modal fade" id="createAsistenciaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('asistencias.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Socio</label>
                        <select name="id_socio" class="form-select" required>
                            @foreach ($socios as $socio)
                                <option value="{{ $socio->id_socio }}">{{ $socio->persona->nom }} {{ $socio->persona->ap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha_asi" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar Asistencia?',
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
                form.action = '/asistencias/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>Swal.fire('Éxito', '{{ session('success') }}', 'success');</script>
@endif

@endsection
