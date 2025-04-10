<div class="modal fade" id="createPedidoModal" tabindex="-1" aria-hidden="true">
    <!-- Modal Header -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nuevo Pedido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal Body -->
            <form method="POST" action="{{ route('GESP.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- Proveedor -->
                    <div class="mb-3">
                        <label for="id_proveedor" class="form-label">Proveedor *</label>
                        <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id_proveedor }}">
                                    {{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Suplemento -->
                    <div class="mb-3">
                        <label for="id_suplemento" class="form-label">Suplemento *</label>
                        <select class="form-select" id="id_suplemento" name="id_suplemento" required>
                            <option value="">Seleccione un suplemento</option>
                            @foreach($suplementos as $suplemento)
                                <option value="{{ $suplemento->id_suplemento }}" 
                                        data-stock="{{ $suplemento->stock }}">
                                    {{ $suplemento->nom_suplemento }} (Stock: {{ $suplemento->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Cantidad -->
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad *</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                    </div>
                    
                    <!-- Fecha -->
                    <div class="mb-3">
                        <label for="fecha_pedido" class="form-label">Fecha del Pedido *</label>
                        <input type="date" class="form-control" id="fecha_pedido" name="fecha_pedido" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>