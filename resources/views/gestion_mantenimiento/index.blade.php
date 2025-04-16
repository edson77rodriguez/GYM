@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Gestión de Mantenimientos</h2>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Listado de Mantenimientos</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#crearMantenimientoModal">
                        <i class="fas fa-plus me-1"></i> Nuevo Mantenimiento
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="mantenimientosTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Equipo</th>
                                    <th>Técnico</th>
                                    <th>Fecha Programada</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mantenimientos as $mantenimiento)
                                <tr>
                                    <td>{{ $mantenimiento->id_mantenimiento }}</td>
                                    <td>{{ $mantenimiento->equipo->nom_equipo }}</td>
                                    <td>{{ $mantenimiento->empleado->persona->nom }} {{ $mantenimiento->empleado->persona->ap }}</td>
                                    <td>{{ $mantenimiento->fecha_programada->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $mantenimiento->desc_estado == 'Pendiente' ? '#ffc107' : ($mantenimiento->desc_estado == 'En progreso' ? '#17a2b8' : ($mantenimiento->desc_estado == 'Completado' ? '#28a745' : '#dc3545')) }}">
                                            {{ $mantenimiento->desc_estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info btn-ver" data-id="{{ $mantenimiento->id_mantenimiento }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning btn-editar" data-id="{{ $mantenimiento->id_mantenimiento }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-eliminar" data-id="{{ $mantenimiento->id_mantenimiento }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="crearMantenimientoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCrearMantenimiento">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Equipo</label>
                            <select class="form-select" name="id_equipo" required>
                                <option value="">Seleccionar equipo</option>
                                @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->id_equipo }}">{{ $equipo->nom_equipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Técnico</label>
                            <select class="form-select" name="id_empleado" required>
                                <option value="">Seleccionar técnico</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id_empleado }}">
                                        {{ $empleado->persona->nom }} {{ $empleado->persona->ap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Fecha Programada</label>
                            <input type="date" class="form-control" name="fecha_programada" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="desc_estado" required>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En progreso">En progreso</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver -->
<div class="modal fade" id="verMantenimientoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detallesMantenimiento">
                <!-- Detalles se cargarán aquí via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarMantenimientoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarMantenimiento">
                <input type="hidden" name="id_mantenimiento" id="edit_id_mantenimiento">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Equipo</label>
                            <select class="form-select" name="id_equipo" id="edit_id_equipo" required>
                                @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->id_equipo }}">{{ $equipo->nom_equipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Técnico</label>
                            <select class="form-select" name="id_empleado" id="edit_id_empleado" required>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id_empleado }}">
                                        {{ $empleado->persona->nom }} {{ $empleado->persona->ap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Fecha Programada</label>
                            <input type="date" class="form-control" name="fecha_programada" id="edit_fecha_programada" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="desc_estado" id="edit_desc_estado" required>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En progreso">En progreso</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarMantenimientoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este mantenimiento?</p>
                <input type="hidden" id="delete_id_mantenimiento">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Crear mantenimiento
    $('#formCrearMantenimiento').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: "{{ route('gestion-mantenimiento.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#crearMantenimientoModal').modal('hide');
                Swal.fire('Éxito', response.message, 'success');
                setTimeout(() => { location.reload(); }, 1000);
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON.message, 'error');
            }
        });
    });

    // Ver mantenimiento
    $('.btn-ver').click(function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ url('gestion-mantenimiento') }}/" + id,
            type: "GET",
            success: function(response) {
                var mantenimiento = response.data;
                var html = `
                    <p><strong>ID:</strong> ${mantenimiento.id_mantenimiento}</p>
                    <p><strong>Equipo:</strong> ${mantenimiento.equipo.nom_equipo}</p>
                    <p><strong>Técnico:</strong> ${mantenimiento.empleado.persona.nom} ${mantenimiento.empleado.persona.ap}</p>
                    <p><strong>Fecha Programada:</strong> ${new Date(mantenimiento.fecha_programada).toLocaleDateString()}</p>
                    <p><strong>Estado:</strong> <span class="badge" style="background-color: ${mantenimiento.desc_estado == 'Pendiente' ? '#ffc107' : (mantenimiento.desc_estado == 'En progreso' ? '#17a2b8' : (mantenimiento.desc_estado == 'Completado' ? '#28a745' : '#dc3545'))}">${mantenimiento.desc_estado}</span></p>
                `;
                
                $('#detallesMantenimiento').html(html);
                $('#verMantenimientoModal').modal('show');
            }
        });
    });

    // Editar mantenimiento - Cargar datos
    $('.btn-editar').click(function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ url('gestion-mantenimiento') }}/" + id,
            type: "GET",
            success: function(response) {
                var m = response.data;
                $('#edit_id_mantenimiento').val(m.id_mantenimiento);
                $('#edit_id_equipo').val(m.id_equipo);
                $('#edit_id_empleado').val(m.id_empleado);
                $('#edit_fecha_programada').val(m.fecha_programada.split('T')[0]);
                $('#edit_desc_estado').val(m.desc_estado);
                
                $('#editarMantenimientoModal').modal('show');
            }
        });
    });

    // Actualizar mantenimiento
    $('#formEditarMantenimiento').submit(function(e) {
        e.preventDefault();
        var id = $('#edit_id_mantenimiento').val();
        
        $.ajax({
            url: "{{ url('gestion-mantenimiento') }}/" + id,
            type: "PUT",
            data: $(this).serialize(),
            success: function(response) {
                $('#editarMantenimientoModal').modal('hide');
                Swal.fire('Éxito', response.message, 'success');
                setTimeout(() => { location.reload(); }, 1000);
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON.message, 'error');
            }
        });
    });

    // Eliminar mantenimiento - Mostrar confirmación
    $('.btn-eliminar').click(function() {
        var id = $(this).data('id');
        $('#delete_id_mantenimiento').val(id);
        $('#eliminarMantenimientoModal').modal('show');
    });

    // Confirmar eliminación
    $('#confirmarEliminar').click(function() {
        var id = $('#delete_id_mantenimiento').val();
        
        $.ajax({
            url: "{{ url('gestion-mantenimiento') }}/" + id,
            type: "DELETE",
            success: function(response) {
                $('#eliminarMantenimientoModal').modal('hide');
                Swal.fire('Éxito', response.message, 'success');
                setTimeout(() => { location.reload(); }, 1000);
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON.message, 'error');
            }
        });
    });
});
</script>
@endsection