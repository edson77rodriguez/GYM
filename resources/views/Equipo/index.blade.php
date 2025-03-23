@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded-3">
                    <div class="card-header text-center bg-primary text-white">
                        <h3><i class="fas fa-dumbbell"></i> Agregar Equipo de Gimnasio</h3>
                    </div>
                    <div class="card-body">
                        <form>

                            <!-- Nombre del equipo -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label"><i class="fas fa-cogs"></i> Nombre del Equipo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del equipo" disabled>
                            </div>

                            <!-- Descripción del equipo -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label"><i class="fas fa-align-left"></i> Descripción del Equipo</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Descripción del equipo" disabled></textarea>
                            </div>

                            <!-- Imagen del equipo -->
                            <div class="mb-3">
                                <label for="imagen" class="form-label"><i class="fas fa-image"></i> Imagen del Equipo</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" disabled>
                            </div>

                            <!-- Botón de enviar -->
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success btn-lg" disabled><i class="fas fa-save"></i> Guardar Equipo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Font Awesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #17a2b8;
            color: white;
            border-radius: 0.75rem;
        }

        .form-label {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .form-control {
            border-radius: 0.75rem;
            box-shadow: none;
            border-color: #ced4da;
        }

        .btn {
            border-radius: 0.75rem;
        }

        .btn:hover {
            background-color: #28a745;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }
    </style>
@endsection
