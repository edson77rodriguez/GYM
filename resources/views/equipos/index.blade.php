@extends('layouts.app')

@section('template_title')
    Equipos
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <!-- Botón para abrir el modal de creación -->
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createEquipoModal">
                {{ __('Agregar Nuevo Equipo') }}
            </button>
        </div>

        <!-- Listado de equipos -->
        @foreach ($equipos as $equipo)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <img src="{{ $equipo->imagen_equipo ? asset('storage/' . $equipo->imagen_equipo) : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $equipo->nom_equipo }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $equipo->nom_equipo }}</h5>
                    <p class="card-text">{{ Str::limit($equipo->desc_equipo, 100) }}</p>
                    <div class="d-flex justify-content-between">
                        <!-- Botón para ver detalles -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewEquipoModal{{ $equipo->id_equipo }}">Ver</button>

                        <!-- Botón para editar -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editEquipoModal{{ $equipo->id_equipo }}">Editar</button>

                        <!-- Botón para eliminar -->
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $equipo->id_equipo }}')">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Equipo -->
        <div class="modal fade" id="viewEquipoModal{{ $equipo->id_equipo }}" tabindex="-1" aria-labelledby="viewEquipoModalLabel{{ $equipo->id_equipo }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewEquipoModalLabel{{ $equipo->id_equipo }}">Detalles del Equipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $equipo->id_equipo }}</p>
                        <p><strong>Nombre:</strong> {{ $equipo->nom_equipo }}</p>
                        <p><strong>Descripción:</strong> {{ $equipo->desc_equipo }}</p>
                        @if ($equipo->imagen_equipo)
                            <img src="{{ asset('storage/' . $equipo->imagen_equipo) }}" class="img-fluid" alt="{{ $equipo->nom_equipo }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Equipo -->
        <div class="modal fade" id="editEquipoModal{{ $equipo->id_equipo }}" tabindex="-1" aria-labelledby="editEquipoModalLabel{{ $equipo->id_equipo }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEquipoModalLabel{{ $equipo->id_equipo }}">Editar Equipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('equipos.update', $equipo->id_equipo) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nom_equipo" class="form-label">Nombre del Equipo</label>
                                <input type="text" name="nom_equipo" class="form-control" id="nom_equipo" value="{{ old('nom_equipo', $equipo->nom_equipo) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc_equipo" class="form-label">Descripción</label>
                                <textarea name="desc_equipo" class="form-control" id="desc_equipo" rows="3">{{ old('desc_equipo', $equipo->desc_equipo) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen_equipo" class="form-label">Imagen</label>
                                <input type="file" name="imagen_equipo" class="form-control" id="imagen_equipo">
                                @if ($equipo->imagen_equipo)
                                    <img src="{{ asset('storage/' . $equipo->imagen_equipo) }}" class="img-fluid mt-2" alt="{{ $equipo->nom_equipo }}">
                                @endif
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Actualizar Equipo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Crear Nuevo Equipo -->
<div class="modal fade" id="createEquipoModal" tabindex="-1" aria-labelledby="createEquipoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEquipoModalLabel">Crear Nuevo Equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('equipos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nom_equipo" class="form-label">Nombre del Equipo</label>
                        <input type="text" name="nom_equipo" class="form-control" id="nom_equipo" value="{{ old('nom_equipo') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="desc_equipo" class="form-label">Descripción</label>
                        <textarea name="desc_equipo" class="form-control" id="desc_equipo" rows="3">{{ old('desc_equipo') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagen_equipo" class="form-label">Imagen</label>
                        <input type="file" name="imagen_equipo" class="form-control" id="imagen_equipo">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Crear Equipo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar Equipo?',
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
                form.action = '/equipos/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
