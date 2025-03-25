<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Socio;
use App\Models\Detalle_Venta;
use App\Models\Suplemento;
use Illuminate\Support\Facades\Session;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['socio', 'detallesVentas.suplemento'])->get();
        $socios = Socio::all();
        $suplementos = Suplemento::all();
    
        return view('ventas.index', compact('ventas', 'socios', 'suplementos'));
    }
    
    // Mostrar formulario para registrar una venta
    public function create()
    {
        $socios = Socio::all();
        return view('ventas.create', compact('socios'));
    }

    // Registrar la venta
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'fecha_venta' => 'required|date',
        ]);

        // Creamos la venta, pero no la finalizamos aún
        $venta = Venta::create([
            'id_socio' => $validatedData['id_socio'],
            'fecha_venta' => $validatedData['fecha_venta'],
            'monto' => 0,  // El monto será calculado después con los detalles
        ]);

        // Redirigimos al formulario para agregar detalles
        return redirect()->route('ventas.detalle', ['venta' => $venta->id_venta])
                         ->with('success', 'Venta registrada. Agregue los detalles de la venta.');
    }

    // Agregar detalles a la venta
    public function agregarDetalles($ventaId)
    {
        $venta = Venta::findOrFail($ventaId);
        $suplementos = Suplemento::all();
        return view('ventas.detalles', compact('venta', 'suplementos'));
    }

    // Guardar detalles de la venta
    public function storeDetalles(Request $request, $ventaId)
    {
        $validatedData = $request->validate([
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer|min:1',
        ]);

        $suplemento = Suplemento::findOrFail($validatedData['id_suplemento']);
        
        // Verificar stock
        if ($suplemento->stock < $validatedData['cantidad']) {
            return redirect()->back()->with('error', 'La cantidad solicitada excede el stock disponible.');
        }
    
        // Calcular subtotal, IVA y total
        $subtotal = $suplemento->precio * $validatedData['cantidad'];  // Subtotal: Precio por cantidad
        $iva = $subtotal * 0.16;  // IVA: 16% del subtotal
        $total = $subtotal + $iva;  // Total: Subtotal más IVA
    
        // Insertar el detalle de la venta
        Detalle_Venta::create([
            'id_venta' => $ventaId,
            'id_suplemento' => $suplemento->id_suplemento,
            'cantidad' => $validatedData['cantidad'],
            'subtotal' => $subtotal,
        ]);
    
        // Actualizar el monto total de la venta
        $venta = Venta::findOrFail($ventaId);
        $venta->monto += $total; // Acumula el monto total de la venta
        $venta->save();
    
        // Actualizar el stock
        $suplemento->stock -= $validatedData['cantidad'];
        $suplemento->save();

        return redirect()->route('ventas.detalle', ['venta' => $ventaId])
                         ->with('success', 'Detalle de venta agregado correctamente.');
    }
    
    // Método para verificar si la venta tiene detalles, si no los tiene la elimina
    public function verificarDetalles($ventaId)
    {
        $venta = Venta::findOrFail($ventaId);
        
        // Si no se han agregado detalles, eliminar la venta
        if ($venta->detallesVentas->count() === 0) {
            $venta->delete();
            return redirect()->route('ventas.index')
                             ->with('error', 'La venta no tiene detalles. Venta eliminada.');
        }

        return redirect()->route('ventas.index');
    }

    // Eliminar una venta
    public function destroy(Venta $venta)
    {
        // Eliminar detalles de la venta antes de eliminar la venta
        $venta->detallesVentas()->delete();
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }

    // Eliminar un detalle de venta
    public function destroyDetalle($detalleId)
    {
        $detalle = Detalle_Venta::findOrFail($detalleId);
        $venta = $detalle->venta;
        
        // Restaurar el stock del suplemento
        $suplemento = $detalle->suplemento;
        $suplemento->stock += $detalle->cantidad;
        $suplemento->save();

        // Restar el monto de la venta
        $venta->monto -= ($detalle->subtotal + $detalle->subtotal * 0.16); // Restar el total con IVA
        $venta->save();

        // Eliminar el detalle
        $detalle->delete();

        return redirect()->route('ventas.detalle', ['venta' => $venta->id_venta])
                         ->with('success', 'Detalle eliminado correctamente.');
    }
}
