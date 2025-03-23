@extends('layouts.app')

@section('template_title')
    Estados de Membresía
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createEstadoModal">
                {{ __('Agregar Nuevo Estado') }}
            </button>
        </div>
        @foreach ($estadosMembresias as $estado)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $estado->nom_estado }}</h5>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewEstadoModal{{ $estado->id_estado_mem }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editEstadoModal{{ $estado->id_estado_mem }}">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $estado->id_estado_mem }}')">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Estado -->
        <div class="modal fade" id="viewEstadoModal{{ $estado->id_estado_mem }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Estado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $estado->id_estado_mem }}</p>
                        <p><strong>Nombre del Estado:</strong> {{ $estado->nom_estado }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Estado -->
        <div class="modal fade" id="editEstadoModal{{ $estado->id_estado_mem }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Estado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('estado_membresias.update', $estado->id_estado_mem) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nombre del Estado</label>
                                <input type="text" name="nom_estado" value="{{ $estado->nom_estado }}" class="form-control" required>
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

<!-- Modal Crear Estado -->
<div class="modal fade" id="createEstadoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('estado_membresias.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre del Estado</label>
                        <input type="text" name="nom_estado" class="form-control" required>
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
            title: '¿Eliminar Estado?',
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
                form.action = '/estado_membresias/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@if(session('register'))
    <script>Swal.fire('Registro exitoso', 'El estado ha sido creado.', 'success');</script>
@endif
@if(session('modify'))
    <script>Swal.fire('Actualización exitosa', 'El estado ha sido actualizado.', 'success');</script>
@endif
@if(session('destroy'))
    <script>Swal.fire('Eliminación exitosa', 'El estado ha sido eliminado.', 'success');</script>
@endif

@endsection
