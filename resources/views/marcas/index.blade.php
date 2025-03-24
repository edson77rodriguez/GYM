@extends('layouts.app')

@section('template_title')
    Gestión de Marcas
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createMarcaModal">
                {{ __('Agregar Nueva Marca') }}
            </button>
        </div>

        @foreach ($marcas as $marca)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $marca->nom_marca }}</h5>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewMarcaModal{{ $marca->id_marca }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editMarcaModal{{ $marca->id_marca }}">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $marca->id_marca }}')">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Marca -->
        <div class="modal fade" id="viewMarcaModal{{ $marca->id_marca }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles de la Marca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $marca->id_marca }}</p>
                        <p><strong>Nombre de la Marca:</strong> {{ $marca->nom_marca }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Marca -->
        <div class="modal fade" id="editMarcaModal{{ $marca->id_marca }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Marca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('marcas.update', $marca->id_marca) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nombre de la Marca</label>
                                <input type="text" name="nom_marca" value="{{ $marca->nom_marca }}" class="form-control" required>
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

<!-- Modal Crear Marca -->
<div class="modal fade" id="createMarcaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nueva Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('marcas.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Marca</label>
                        <input type="text" name="nom_marca" class="form-control" required>
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
            title: '¿Eliminar Marca?',
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
                form.action = '/marcas/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@if(session('register'))
    <script>Swal.fire('Registro exitoso', 'La marca ha sido creada.', 'success');</script>
@endif
@if(session('modify'))
    <script>Swal.fire('Actualización exitosa', 'La marca ha sido actualizada.', 'success');</script>
@endif
@if(session('destroy'))
    <script>Swal.fire('Eliminación exitosa', 'La marca ha sido eliminada.', 'success');</script>
@endif

@endsection
