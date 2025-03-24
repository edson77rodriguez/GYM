<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Socio;
use App\Models\Detalle_Venta;
use App\Models\Suplemento;

class VentaController extends Controller
{
    // Mostrar todas las ventas
    public function index()
    {
        $ventas = Venta::with(['socio', 'detallesVentas.suplemento'])->get();
        $socios = Socio::all();
        $suplementos = Suplemento::all();

        return view('ventas.index', compact('ventas', 'socios', 'suplementos'));
    }

    // Almacenar una nueva venta
    public function store(Request $request)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'fecha_venta' => 'required|date',
        ]);

        // Crear la venta con monto inicial 0
        $venta = Venta::create([
            'id_socio' => $validatedData['id_socio'],
            'fecha_venta' => $validatedData['fecha_venta'],
            'monto' => 0, 
        ]);

        return redirect()->route('ventas.detalles', $venta->id_venta)
                         ->with('success', 'Venta registrada correctamente.');
    }

    // Actualizar una venta
    public function update(Request $request, Venta $venta)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'fecha_venta' => 'required|date',
            'detalles_venta' => 'required|array',
            'detalles_venta.*.id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'detalles_venta.*.cantidad' => 'required|integer|min:1',
        ]);

        // Actualizar la venta
        $venta->update([
            'id_socio' => $validatedData['id_socio'],
            'fecha_venta' => $validatedData['fecha_venta'],
        ]);

        // Eliminar los detalles de la venta antiguos
        $venta->detallesVentas()->delete();

        // Recalcular el total
        $total = 0;

        foreach ($request->detalles_venta as $detalle) {
            $suplemento = Suplemento::findOrFail($detalle['id_suplemento']);
            $subtotal = $detalle['cantidad'] * $suplemento->precio;

            Detalle_Venta::create([
                'id_venta' => $venta->id_venta,
                'id_suplemento' => $suplemento->id_suplemento,
                'cantidad' => $detalle['cantidad'],
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }

        // Actualizar el monto total de la venta
        $venta->update(['monto' => $total]);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    // Eliminar una venta
    public function destroy(Venta $venta)
    {
        $venta->detallesVentas()->delete();
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }

    // Mostrar detalles de una venta
    public function detalles($id_venta)
    {
        $venta = Venta::findOrFail($id_venta);
        $suplementos = Suplemento::all();

        return view('ventas.detalles', compact('venta', 'suplementos'));
    }

    // Almacenar detalles de una venta
    public function storeDetalles(Request $request, $id_venta)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'detalles_venta' => 'required|array',
            'detalles_venta.*.id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'detalles_venta.*.cantidad' => 'required|integer|min:1',
        ]);

        // Obtener la venta
        $venta = Venta::findOrFail($id_venta);
        $total = 0;

        foreach ($request->detalles_venta as $detalle) {
            $suplemento = Suplemento::findOrFail($detalle['id_suplemento']);
            $subtotal = $detalle['cantidad'] * $suplemento->precio;

            Detalle_Venta::create([
                'id_venta' => $venta->id_venta,
                'id_suplemento' => $suplemento->id_suplemento,
                'cantidad' => $detalle['cantidad'],
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }

        // Actualizar el monto total de la venta
        $venta->update(['monto' => $total]);

        return redirect()->route('ventas.index')->with('success', 'Detalles de venta registrados correctamente.');
    }
}
