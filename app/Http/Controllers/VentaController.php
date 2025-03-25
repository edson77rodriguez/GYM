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

        $venta = Venta::create([
            'id_socio' => $validatedData['id_socio'],
            'fecha_venta' => $validatedData['fecha_venta'],
            'monto' => 0,  // El monto será calculado después con los detalles
        ]);

        return redirect()->route('ventas.detalle', ['venta' => $venta->id_venta])
                         ->with('success', 'Venta registrada exitosamente.');
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

    $subtotal = $suplemento->precio * $validatedData['cantidad'];
    $iva = $subtotal * 0.16;
    $total = $subtotal + $iva;

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
public function destroy(Venta $venta)
{
    $venta->detallesVentas()->delete();
    $venta->delete();

    return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
}
}

