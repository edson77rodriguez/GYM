@extends('layouts.app')

@section('template_title')
    Gestión de Socios
@endsection

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold text-uppercase">Gestión de Socios</h2>
        </div>

        <!-- Barra de búsqueda -->
        <div class="col-12 mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar socio por nombre...">
        </div>

        <div class="col-12 text-end mb-3">
            <!-- Botón para agregar un nuevo socio -->
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>
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
                <tbody id="sociosTable">
                    @foreach ($socios as $socio)
                        @php
                            $hoy = now();
                            $vencimiento = $socio->fecha_vencimiento;
                            $diasRestantes = $hoy->diffInDays($vencimiento, false);
                            $estadoClase = '';
                            
                            if ($diasRestantes < 0) {
                                $estadoTexto = 'Vencido';
                                $estadoClase = 'text-danger fw-bold';
                            } elseif ($diasRestantes <= 30) {
                                $estadoTexto = 'Por vencer';
                                $estadoClase = 'text-warning fw-bold';
                            } else {
                                $estadoTexto = 'Activo';
                                $estadoClase = 'text-success fw-bold';
                            }
                        @endphp
                        
                        <tr class="socio-row">
                            <td>{{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</td>
                            <td class="{{ $estadoClase }}">{{ $estadoTexto }}</td>
                            <td>{{ $socio->fecha_inscripcion->format('d-m-Y') }}</td>
                            <td>{{ $socio->fecha_vencimiento->format('d-m-Y') }}</td>
                            <td>
                                <!-- Botones de acciones -->
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewSocioModal{{ $socio->id_socio }}">Ver</button>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#membresiaModal{{ $socio->id_socio }}">Asignar Membresía</button>
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
                                        <p><strong>Estado Membresía:</strong> {{ $estadoTexto }}</p>
                                        <p><strong>Fecha Inscripción:</strong> {{ $socio->fecha_inscripcion->format('d-m-Y') }}</p>
                                        <p><strong>Fecha Vencimiento:</strong> {{ $socio->fecha_vencimiento->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Asignar Membresía -->
                        <div class="modal fade" id="membresiaModal{{ $socio->id_socio }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Asignar Membresía a {{ $socio->persona->nom }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('membresias.storee') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_socio" value="{{ $socio->id_socio }}">
                                            
                                            <!-- Selección de plan -->
                                            <div class="mb-3">
                                                <label for="id_plan" class="form-label">Selecciona un Plan</label>
                                                <select name="id_plan" class="form-select" required>
                                                    <option value="">Selecciona un Plan</option>
                                                    @foreach ($planes as $plan)
                                                        <option value="{{ $plan->id_plan }}">{{ $plan->nom_plan }} - ${{ $plan->costo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Botones del modal -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success">Asignar Membresía</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
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
                        <label for="telefono" class="form-label">TelÃ©fono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo ElectrÃ³nico</label>
                        <input type="email" name="correo" id="correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_inscripcion" class="form-label">Fecha de InscripciÃ³n</label>
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


<!-- Script de búsqueda en tiempo real -->
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll(".socio-row");
        rows.forEach(row => {
            let name = row.cells[0].innerText.toLowerCase();
            row.style.display = name.includes(filter) ? "" : "none";
        });
    });
</script>
@endsection
