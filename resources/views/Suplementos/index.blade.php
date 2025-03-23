@extends('layouts.app')

@section('template_title')
    Suplementos
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-end mb-3">
        <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
    {{ __('Regresar a Home') }}
</button>


            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createSuplementoModal">
                {{ __('Agregar Nuevo Suplemento') }}
            </button>
        </div>
        @foreach ($suplementos as $suplemento)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-light">
                <img src="{{ $suplemento->imagen_suplemento ? asset('storage/' . $suplemento->imagen_suplemento) : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $suplemento->nom_suplemento }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $suplemento->nom_suplemento }}</h5>
                    <p class="card-text"><strong>Categoría:</strong> {{ $suplemento->categoria->nom_cat }}</p>
                    <p class="card-text"><strong>Marca:</strong> {{ $suplemento->marca->nom_marca }}</p>
                    <p class="card-text"><strong>Precio:</strong> ${{ number_format($suplemento->precio, 2) }}</p>
                    <p class="card-text"><strong>Stock:</strong> {{ $suplemento->stock }}</p>
                    <p class="card-text"><strong>Descripción:</strong> {{ Str::limit($suplemento->desc_suplemento, 100) }}</p>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewSuplementoModal{{ $suplemento->id_suplemento }}">Ver</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSuplementoModal{{ $suplemento->id_suplemento }}">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $suplemento->id_suplemento }}')">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Suplemento -->
        <div class="modal fade" id="viewSuplementoModal{{ $suplemento->id_suplemento }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Suplemento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $suplemento->id_suplemento }}</p>
                        <p><strong>Nombre Suplemento:</strong> {{ $suplemento->nom_suplemento }}</p>
                        <p><strong>Categoría:</strong> {{ $suplemento->categoria->nom_cat }}</p>
                        <p><strong>Marca:</strong> {{ $suplemento->marca->nom_marca }}</p>
                        <p><strong>Precio:</strong> ${{ number_format($suplemento->precio, 2) }}</p>
                        <p><strong>Stock:</strong> {{ $suplemento->stock }}</p>
                        <p><strong>Descripción:</strong> {{ $suplemento->desc_suplemento }}</p>
                        @if ($suplemento->imagen_suplemento)
                        <img src="{{ asset('storage/' . $suplemento->imagen_suplemento) }}" class="card-img-top" alt="{{ $suplemento->nom_suplemento }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Suplemento -->
        <div class="modal fade" id="editSuplementoModal{{ $suplemento->id_suplemento }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Suplemento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('suplementos.update', $suplemento->id_suplemento) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nombre Suplemento</label>
                                <input type="text" name="nom_suplemento" value="{{ $suplemento->nom_suplemento }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <select name="id_categoria" class="form-select" required>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}" {{ $suplemento->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>{{ $categoria->nom_cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Marca</label>
                                <select name="id_marca" class="form-select" required>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id_marca }}" {{ $suplemento->id_marca == $marca->id_marca ? 'selected' : '' }}>{{ $marca->nom_marca }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="desc_suplemento" class="form-control" rows="3">{{ $suplemento->desc_suplemento }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Precio</label>
                                <input type="number" name="precio" value="{{ $suplemento->precio }}" class="form-control" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" value="{{ $suplemento->stock }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Imagen (Opcional)</label>
                                <input type="file" name="imagen_suplemento" class="form-control">
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

<!-- Modal Crear Suplemento -->
<div class="modal fade" id="createSuplementoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Suplemento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('suplementos.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre Suplemento</label>
                        <input type="text" name="nom_suplemento" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <select name="id_categoria" class="form-select" required>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nom_cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca</label>
                        <select name="id_marca" class="form-select" required>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id_marca }}">{{ $marca->nom_marca }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="desc_suplemento" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <input type="file" name="imagen_suplemento" class="form-control">
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
            title: '¿Eliminar Suplemento?',
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
                form.action = '/suplementos/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@if(session('register'))
    <script>Swal.fire('Registro exitoso', 'El suplemento ha sido creado.', 'success');</script>
@endif
@if(session('modify'))
    <script>Swal.fire('Actualización exitosa', 'El suplemento ha sido actualizado.', 'success');</script>
@endif
@if(session('destroy'))
    <script>Swal.fire('Eliminación exitosa', 'El suplemento ha sido eliminado.', 'success');</script>
@endif

@endsection
