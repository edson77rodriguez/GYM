@extends('layouts.app')

@section('template_title')
    Gestión de Pedidos
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <!-- Panel de filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filtros</h5>
                </div>
                <div class="card-body">
                    <form id="searchForm">
                        <div class="mb-3">
                            <label class="form-label">Proveedor</label>
                            <select name="proveedor" class="form-select">
                                <option value="">Todos</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id_proveedor }}">
                                        {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }} {{ $proveedor->persona->am }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Suplemento</label>
                            <select name="suplemento" class="form-select">
                                <option value="">Todos</option>
                                @foreach($suplementos as $suplemento)
                                    <option value="{{ $suplemento->id_suplemento }}">
                                        {{ $suplemento->nom_suplemento }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rango de fechas</label>
                            <div class="input-group">
                                <input type="date" name="fecha_inicio" class="form-control">
                                <span class="input-group-text">a</span>
                                <input type="date" name="fecha_fin" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </form>
                </div>
            </div>

            <!-- Panel de suplementos bajos en stock -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Stock Bajo</h5>
                </div>
                <div class="card-body" id="lowStockContainer">
                    @foreach($suplementos->where('stock', '<', 10) as $suplemento)
                        <div class="alert alert-danger py-2 mb-2">
                            <strong>{{ $suplemento->nom_suplemento }}</strong>
                            <p class="mb-0">Stock: {{ $suplemento->stock }}</p>
                            <button class="btn btn-sm btn-outline-primary mt-1" 
                                    onclick="quickOrder({{ $suplemento->id_suplemento }})">
                                Pedir ahora
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Listado de Pedidos</h5>
                        <div>
                            <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                                {{ __('Regresar a Home') }}
                            </button>
                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createPedidoModal">
                                <i class="fas fa-plus"></i> Nuevo Pedido
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Proveedor</th>
                                    <th>Suplemento</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="pedidosTableBody">
                                @include('GESP._pedidos_table', ['pedidos' => $pedidos])

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales (similar a los que ya tienes, pero mejorados) -->
@include('GESP.modals.create')
@include('GESP.modals.edit')
@include('GESP.modals.view')
<script>
    // Búsqueda AJAX
    $('#searchForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('GESP.search') }}",
            type: "GET",
            data: $(this).serialize(),
            success: function(data) {
                $('#pedidosTableBody').html(data);
            }
        });
    });

    // Pedido rápido para stock bajo
  // Pedido rápido para stock bajo - Versión compatible con tu estructura
function quickOrder(suplementoId) {
    // Obtener el select de suplementos del modal
    const suplementoSelect = $('#createPedidoModal #id_suplemento');
    
    // Establecer el suplemento seleccionado
    suplementoSelect.val(suplementoId);
    
    // Disparar el evento change para posibles dependencias
    suplementoSelect.trigger('change');
    
    // Calcular cantidad sugerida (puedes ajustar esta lógica)
    const suggestedQty = 20; // Cantidad base
    $('#createPedidoModal #cantidad').val(suggestedQty);
    
    // Mostrar el modal
    $('#createPedidoModal').modal('show');
}

    // Actualizar stock bajo cada 5 minutos
    setInterval(function() {
        $.get("{{ route('GESP.checkLowStock') }}", function(data) {
            let html = '';
            data.forEach(function(suplemento) {
                html += `
                <div class="alert alert-danger py-2 mb-2">
                    <strong>${suplemento.nom_suplemento}</strong>
                    <p class="mb-0">Stock: ${suplemento.stock}</p>
                    <button class="btn btn-sm btn-outline-primary mt-1" 
                            onclick="quickOrder(${suplemento.id_suplemento})">
                        Pedir ahora
                    </button>
                </div>`;
            });
            $('#lowStockContainer').html(html || '<p class="text-muted">No hay suplementos con stock bajo</p>');
        });
    }, 300000); // 5 minutos
</script>
@endsection