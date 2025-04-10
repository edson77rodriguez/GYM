@foreach($pedidos as $pedido)
<tr>
    <td>{{ $pedido->id_pedido }}</td>
    <td>{{ $pedido->proveedor->persona->nom }} {{ $pedido->proveedor->persona->ap }}</td>
    <td>{{ $pedido->suplemento->nom_suplemento }}</td>
    <td>{{ $pedido->cantidad }}</td>
    <td>{{ $pedido->fecha_pedido->format('d/m/Y') }}</td>
    <td>
        @if($pedido->recibido)
            <span class="badge bg-success">Recibido</span>
        @else
            <span class="badge bg-warning">Pendiente</span>
        @endif
    </td>
    <td>
        <div class="btn-group btn-group-sm">
            <button class="btn btn-info" data-bs-toggle="modal" 
                    data-bs-target="#viewPedidoModal{{ $pedido->id_pedido }}">
                <i class="fas fa-eye"></i>
            </button>
            
            @if(!$pedido->recibido)
                <form action="{{ route('GESP.recibir', $pedido->id_pedido) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" title="Marcar como recibido">
                        <i class="fas fa-check"></i>
                    </button>
                </form>
            @endif
            
            <button class="btn btn-primary" data-bs-toggle="modal" 
                    data-bs-target="#editPedidoModal{{ $pedido->id_pedido }}">
                <i class="fas fa-edit"></i>
            </button>
            
            <form action="{{ route('GESP.destroy', $pedido->id_pedido) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar pedido?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach