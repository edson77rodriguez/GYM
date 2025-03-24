@extends('layouts.app')

@section('template_title')
    Detalles de Venta
@endsection

@section('content')
<div class="container py-5">
    <h3>Registrar Detalles de la Venta</h3>
    <form action="{{ route('ventas.storeDetalles', $venta->id_venta) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Venta: </label>
            <p>{{ $venta->socio->nombre }} {{ $venta->socio->apellido }} - {{ $venta->fecha_venta }}</p>
        </div>

        <div class="mb-3">
            <h5>Detalles de la Venta:</h5>
            <div id="detallesVenta">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <select name="detalles_venta[0][id_suplemento]" class="form-select" required>
                            <option value="">Seleccionar Suplemento</option>
                            @foreach ($suplementos as $suplemento)
                                <option value="{{ $suplemento->id_suplemento }}">{{ $suplemento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="detalles_venta[0][cantidad]" class="form-control" placeholder="Cantidad" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="detalles_venta[0][precio]" class="form-control" placeholder="Precio" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" id="addDetalleBtn">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Guardar Detalles</button>
        </div>
    </form>
</div>

<script>
    let detalleIndex = 1;
    document.getElementById('addDetalleBtn').addEventListener('click', function() {
        let detallesVentaDiv = document.getElementById('detallesVenta');
        let newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-2');
        newRow.innerHTML = `
            <div class="col-md-4">
                <select name="detalles_venta[${detalleIndex}][id_suplemento]" class="form-select" required>
                    <option value="">Seleccionar Suplemento</option>
                    @foreach ($suplementos as $suplemento)
                        <option value="{{ $suplemento->id_suplemento }}">{{ $suplemento->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="detalles_venta[${detalleIndex}][cantidad]" class="form-control" placeholder="Cantidad" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="detalles_venta[${detalleIndex}][precio]" class="form-control" placeholder="Precio" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger removeDetalleBtn">Eliminar</button>
            </div>
        `;
        detallesVentaDiv.appendChild(newRow);
        detalleIndex++;

        // Eliminar detalle
        newRow.querySelector('.removeDetalleBtn').addEventListener('click', function() {
            detallesVentaDiv.removeChild(newRow);
        });
    });
</script>
@endsection
