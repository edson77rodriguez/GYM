@extends('layouts.app')

@section('template_title')
    Socios
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
    <div class="col-12 text-center mb-4">
    <h2 class="fw-bold text-uppercase">Socios</h2>
    </div>
        <div class="col-12 text-end mb-3">
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
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewSocioModal{{ $socio->id_socio }}">Ver</button>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSocioModal{{ $socio->id_socio }}">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $socio->id_socio }}')">Eliminar</button>
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

                        <!-- Modal Editar Socio -->
                        <div class="modal fade" id="editSocioModal{{ $socio->id_socio }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Socio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('socios.update', $socio->id_socio) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Persona</label>
                                                <select name="id_persona" class="form-select" required>
                                                <option>Selecciona a tu socio</option>
                                                    @foreach ($personas as $persona)
                                                        <option value="{{ $persona->id_persona }}" {{ $socio->id_persona == $persona->id_persona ? 'selected' : '' }}>{{ $socio->persona->nom }} {{ $socio->persona->ap }} {{ $socio->persona->am }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Estado Membresía</label>
                                                <select name="id_estado_mem" class="form-select" required>
                                                <option>Selecciona su estado de membresia</option>
                                                    @foreach ($estados as $estado)
                                                        <option value="{{ $estado->id_estado_mem }}" {{ $socio->id_estado_mem == $estado->id_estado_mem ? 'selected' : '' }}>{{ $estado->nom_estado }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha Inscripción</label>
                                                <input type="date" name="fecha_inscripcion" value="{{ $socio->fecha_inscripcion->format('Y-m-d') }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha Vencimiento</label>
                                                <input type="date" name="fecha_vencimiento" value="{{ $socio->fecha_vencimiento->format('Y-m-d') }}" class="form-control" required>
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

<!-- Modal Crear Socio -->
<div class="modal fade" id="createSocioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Socio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('socios.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Persona</label>
                        <select name="id_persona" class="form-select" required>
                        <option>Selecciona a tu nuevo socio</option>
                            @foreach ($personas as $persona)
                                <option value="{{ $persona->id_persona }}">{{ $persona->nom }} {{ $persona->ap }} {{ $persona->am }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado Membresía</label>
                        <select name="id_estado_mem" class="form-select" required>
                        <option>Selecciona el estado de membresia</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado_mem }}">{{ $estado->nom_estado }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Inscripción</label>
                        <input type="date" name="fecha_inscripcion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" class="form-control" required>
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
            title: '¿Eliminar Socio?',
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
                form.action = '/socios/' + id;
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
