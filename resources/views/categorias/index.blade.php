@extends('layouts.app')

@section('template_title')
    Gestión de Categorías
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                {{ __('Regresar a Home') }}
            </button>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createCategoriaModal">
                {{ __('Agregar Nueva Categoría') }}
            </button>
        </div>

        @foreach ($categorias as $categoria)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">{{ $categoria->nom_cat }}</h5>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewCategoriaModal{{ $categoria->id_categoria }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoriaModal{{ $categoria->id_categoria }}">Editar</button>
                        <form onsubmit="event.preventDefault(); confirmDelete({{ $categoria->id_categoria }});" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Categoría -->
        <div class="modal fade" id="viewCategoriaModal{{ $categoria->id_categoria }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles de la Categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $categoria->id_categoria }}</p>
                        <p><strong>Nombre de la Categoría:</strong> {{ $categoria->nom_cat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Categoría -->
        <div class="modal fade" id="editCategoriaModal{{ $categoria->id_categoria }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('categorias.update', $categoria->id_categoria) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nombre de la Categoría</label>
                                <input type="text" name="nom_cat" value="{{ $categoria->nom_cat }}" class="form-control" required>
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

<!-- Modal Crear Categoría -->
<div class="modal fade" id="createCategoriaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('categorias.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Categoría</label>
                        <input type="text" name="nom_cat" class="form-control" required>
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
            title: '¿Eliminar Categoría?',
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
                form.action = '/categorias/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('register'))
    <script>Swal.fire('Registro exitoso', 'La categoría ha sido creada.', 'success');</script>
@endif
@if(session('modify'))
    <script>Swal.fire('Actualización exitosa', 'La categoría ha sido actualizada.', 'success');</script>
@endif
@if(session('destroy'))
    <script>Swal.fire('Eliminación exitosa', 'La categoría ha sido eliminada.', 'success');</script>
@endif

@endsection
