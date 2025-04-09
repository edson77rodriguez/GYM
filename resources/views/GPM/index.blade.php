@extends('layouts.app')

@section('template_title')
    Gestión de Proveedores
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold text-uppercase">Gestión de Proveedores</h2>
            </div>

            <div class="col-12 text-end mb-3">
                <!-- Botón para agregar un nuevo proveedor -->
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createProveedorModal">
                    {{ __('Agregar Nuevo Proveedor') }}
                </button>
            </div>

            <!-- Tabla de proveedores -->
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }} {{ $proveedor->persona->am }}</td>
                            <td>{{ $proveedor->persona->telefono }}</td>
                            <td>{{ $proveedor->persona->correo }}</td>
                            <td>
                                <!-- Ver Proveedor -->
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewProveedorModal{{ $proveedor->id_proveedor }}">Ver</button>
                            </td>
                        </tr>

                        <!-- Modal Ver Proveedor -->
                        <div class="modal fade" id="viewProveedorModal{{ $proveedor->id_proveedor }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detalles del Proveedor</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nombre:</strong> {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }} {{ $proveedor->persona->am }}</p>
                                        <p><strong>Teléfono:</strong> {{ $proveedor->persona->telefono }}</p>
                                        <p><strong>Correo:</strong> {{ $proveedor->persona->correo }}</p>
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

    <!-- Modal para crear un nuevo proveedor -->
    <div class="modal fade" id="createProveedorModal" tabindex="-1" aria-labelledby="createProveedorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProveedorModalLabel">Crear Nuevo Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('GPM.store') }}" method="POST">
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
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electronico</label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-dark">Crear Proveedor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
