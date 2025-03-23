@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg rounded-3 border-0">
            <div class="card-header bg-primary text-white text-center">
                <h3><i class="fas fa-capsules"></i> Formulario de Suplementos</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group mb-4">
                        <label for="nombre"><i class="fas fa-capsules"></i> Nombre del Suplemento</label>
                        <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Nombre del suplemento" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="descripcion"><i class="fas fa-file-alt"></i> Descripción</label>
                        <textarea class="form-control form-control-lg" id="descripcion" name="descripcion" rows="4" placeholder="Descripción del suplemento" required></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="precio"><i class="fas fa-dollar-sign"></i> Precio (MXN)</label>
                        <div class="input-group">
                            <span class="input-group-text" id="precio-symbol">$</span>
                            <input type="number" class="form-control form-control-lg" id="precio" name="precio" step="0.01" placeholder="Precio del suplemento" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="stock"><i class="fas fa-box"></i> Stock</label>
                        <input type="number" class="form-control form-control-lg" id="stock" name="stock" placeholder="Cantidad en stock" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="categoria"><i class="fas fa-th-large"></i> Selecciona la Categoría</label>
                        <select class="form-control form-control-lg" id="categoria" name="categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="proteinas">Proteínas</option>
                            <option value="vitaminas">Vitaminas</option>
                            <option value="minerales">Minerales</option>
                            <option value="aminoacidos">Aminoácidos</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="marca"><i class="fas fa-registered"></i> Selecciona la Marca</label>
                        <select class="form-control form-control-lg" id="marca" name="marca" required>
                            <option value="">Seleccione una marca</option>
                            <option value="marca1">Marca 1</option>
                            <option value="marca2">Marca 2</option>
                            <option value="marca3">Marca 3</option>
                            <option value="marca4">Marca 4</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg btn-block">
                        <i class="fas fa-save"></i> Guardar Suplemento
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Font Awesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Estilos adicionales con Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
@endsection
