@foreach($pedidos as $pedido)
<div class="modal fade" id="viewPedidoModal{{ $pedido->id_pedido }}" tabindex="-1" aria-labelledby="viewPedidoModalLabel{{ $pedido->id_pedido }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewPedidoModalLabel{{ $pedido->id_pedido }}">Detalles del Pedido #{{ $pedido->id_pedido }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Información del Proveedor</h6>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">
                                <strong>Nombre:</strong> 
                                {{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }}
                            </li>
                            <li class="list-group-item">
                                <strong>Teléfono:</strong> {{ $pedido->proveedor->persona->telefono ?? 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Correo:</strong> {{ $pedido->proveedor->persona->correo ?? 'N/A' }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Detalles del Pedido</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Suplemento:</strong> {{ $pedido->suplemento->nom_suplemento }}
                            </li>
                            <li class="list-group-item">
                                <strong>Categoría:</strong> {{ $pedido->suplemento->categoria->nombre ?? 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Cantidad:</strong> {{ $pedido->cantidad }}
                            </li>
                            <li class="list-group-item">
                                <strong>Fecha:</strong> 
                                @if($pedido->fecha_pedido instanceof \Carbon\Carbon)
                                    {{ $pedido->fecha_pedido->format('d/m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}
                                @endif
                            </li>
                           <!-- En la sección de detalles del pedido -->
                        <li class="list-group-item">
                            <strong>Estado:</strong> 
                            @if($pedido->recibido)
                                <span class="badge bg-success">Recibido (Stock actualizado)</span>
                            @else
                                <span class="badge bg-warning">Pendiente de recepción</span>
                            @endif
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach