@extends('layouts.app')

@section('template_title')
    Gestion de Socios
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold text-uppercase">Gestión de Socios</h2>
        </div>

        <div class="col-12 text-end mb-3">
            <!-- Botón para agregar un nuevo socio -->
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createSocioModal">
                {{ __('Agregar Nuevo Socio') }}
            </button>

            <!-- Botón para registrar una nueva persona -->
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createPersonaModal">
                {{ __('Registrar Nueva Persona') }}
            </button>
        </div>

        <!-- Tabla de socios -->
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Persona</th>
                        <th>Estado Membresía</th>
                        <th>Fecha Inscripción</th>
                        <th>Fecha Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($socios as $socio)
                        <tr>
                            <td>{{ $socio->id_socio }}</td>
                            <td>{{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</td>
                            <td>{{ $socio->estadoMembresia->nom_estado }}</td>
                            <td>{{ $socio->fecha_inscripcion->format('d-m-Y') }}</td>
                            <td>{{ $socio->fecha_vencimiento->format('d-m-Y') }}</td>
                            <td>
                                <!-- Ver Socio -->
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewSocioModal{{ $socio->id_socio }}">Ver</button>

                                <!-- Membresía -->
                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#membresiaModal{{ $socio->id_socio }}">Membresía</button>
                            </td>
                        </tr>

                        <!-- Modal Ver Socio -->
                        <div class="modal fade" id="viewSocioModal{{ $socio->id_socio }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detalles del Socio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>ID:</strong> {{ $socio->id_socio }}</p>
                                        <p><strong>Persona:</strong> {{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</p>
                                        <p><strong>Estado Membresía:</strong> {{ $socio->estadoMembresia->nom_estado }}</p>
                                        <p><strong>Fecha Inscripción:</strong> {{ $socio->fecha_inscripcion->format('d-m-Y') }}</p>
                                        <p><strong>Fecha Vencimiento:</strong> {{ $socio->fecha_vencimiento->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Membresía (acción) -->
                        <div class="modal fade" id="membresiaModal{{ $socio->id_socio }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Membresía del Socio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Estado Membresía:</strong> {{ $socio->estadoMembresia->nom_estado }}</p>
                                        <p><strong>Fecha Vencimiento:</strong> {{ $socio->fecha_vencimiento->format('d-m-Y') }}</p>
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

<!-- Modal para crear un nuevo socio -->
<div class="modal fade" id="createSocioModal" tabindex="-1" aria-labelledby="createSocioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSocioModalLabel">Crear Nuevo Socio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('socios.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_persona" class="form-label">Persona</label>
                        <select name="id_persona" id="id_persona" class="form-select" required>
                            <option value="">Selecciona una Persona</option>
                            @foreach ($personas as $persona)
                                <option value="{{ $persona->id_persona }}">{{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_inscripcion" class="form-label">Fecha Inscripción</label>
                        <input type="date" name="fecha_inscripcion" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-dark">Crear Socio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar nueva persona (no tiene ruta aún) -->
<div class="modal fade" id="createPersonaModal" tabindex="-1" aria-labelledby="createPersonaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPersonaModalLabel">Registrar Nueva Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Formulario para registrar una nueva persona.</p>
                <!-- Aquí puedes agregar el formulario para registrar una persona -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info">Registrar Persona</button>
            </div>
        </div>
    </div>
</div>
@endsection
