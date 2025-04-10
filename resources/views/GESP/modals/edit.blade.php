@foreach($pedidos as $pedido)
<div class="modal fade" id="editPedidoModal{{ $pedido->id_pedido }}" tabindex="-1" aria-labelledby="editPedidoModalLabel{{ $pedido->id_pedido }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editPedidoModalLabel{{ $pedido->id_pedido }}">Editar Pedido #{{ $pedido->id_pedido }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('GESP.update', $pedido->id_pedido) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Proveedor *</label>
                            <select name="id_proveedor" class="form-select" required>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id_proveedor }}" {{ $pedido->id_proveedor == $proveedor->id_proveedor ? 'selected' : '' }}>
                                        {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Suplemento *</label>
                            <select name="id_suplemento" class="form-select" required>
                                @foreach($suplementos as $suplemento)
                                    <option value="{{ $suplemento->id_suplemento }}" {{ $pedido->id_suplemento == $suplemento->id_suplemento ? 'selected' : '' }}>
                                        {{ $suplemento->nom_suplemento }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Cantidad *</label>
                            <input type="number" name="cantidad" value="{{ $pedido->cantidad }}" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha del Pedido *</label>
                            <input type="date" name="fecha_pedido" value="{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('Y-m-d') }}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach