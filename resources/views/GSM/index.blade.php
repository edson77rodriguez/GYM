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

        </div>

        <!-- Tabla de socios -->
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
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

<!-- Modal para crear un nuevo socio con datos personales -->
<div class="modal fade" id="createSocioModal" tabindex="-1" aria-labelledby="createSocioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSocioModalLabel">Crear Nuevo Socio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('GSM.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nombre</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ap" class="form-label">Apellido Paterno</label>
                        <input type="text" name="ap" id="ap" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="am" class="form-label">Apellido Materno</label>
                        <input type="text" name="am" id="am" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_inscripcion" class="form-label">Fecha de Inscripción</label>
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
