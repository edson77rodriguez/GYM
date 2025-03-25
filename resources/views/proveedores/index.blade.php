@extends('layouts.app')

@section('template_title')
    Proveedores
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createProveedorModal">
                {{ __('Registrar Proveedor') }}
            </button>
        </div>
        @foreach ($proveedores as $proveedor)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}</h5>
                    <p class="card-text"><strong>Persona Asociada:</strong> {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}</p>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewProveedorModal{{ $proveedor->id_proveedor }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProveedorModal{{ $proveedor->id_proveedor }}">Editar</button>
                        <form onsubmit="event.preventDefault(); confirmDelete({{ $proveedor->id_proveedor }});" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Proveedor -->
        <div class="modal fade" id="viewProveedorModal{{ $proveedor->id_proveedor }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nombre:</strong> {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}</p>
                        <p><strong>Correo:</strong> {{ $proveedor->persona->correo }}</p>
                        <p><strong>Teléfono:</strong> {{ $proveedor->persona->telefono }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Proveedor -->
        <div class="modal fade" id="editProveedorModal{{ $proveedor->id_proveedor }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('proveedores.update', $proveedor->id_proveedor) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Persona Asociada</label>
                                <select name="id_persona" class="form-select" required>
                                    @foreach ($personas as $persona)
                                        <option value="{{ $persona->id_persona }}" {{ $proveedor->id_persona == $persona->id_persona ? 'selected' : '' }}>
                                            {{ $persona->nom }} {{ $persona->ap }}
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

<!-- Modal Crear Proveedor -->
<div class="modal fade" id="createProveedorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('proveedores.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Persona Asociada</label>
                        <select name="id_persona" class="form-select" required>
                            @foreach ($personas as $persona)
                                <option value="{{ $persona->id_persona }}">{{ $persona->nom }} {{ $persona->ap }}</option>
                            @endforeach
                        </select>
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
            title: '¿Eliminar Proveedor?',
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
                form.action = '/proveedores/' + id;
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
