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

    // Crear la venta con monto 0
    $venta = Venta::create([
        'id_socio' => $validatedData['id_socio'],
        'fecha_venta' => $validatedData['fecha_venta'],
        'monto' => 0, // El monto inicial es 0
    ]);

    // Redirigir a la página de detalles de la venta
    return redirect()->route('ventas.detalles', $venta->id_venta)->with('success', 'Venta registrada correctamente.');
}


    // Actualizar una venta
    public function update(Request $request, Venta $venta)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'fecha_venta' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'detalles_venta' => 'required|array',
            'detalles_venta.*.id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'detalles_venta.*.cantidad' => 'required|integer|min:1',
            'detalles_venta.*.precio' => 'required|numeric|min:0',
        ]);

        // Actualizar la venta
        $venta->update($validatedData);

        // Eliminar los detalles de la venta antiguos y crear los nuevos
        $venta->detallesVentas()->delete();  // Eliminar detalles anteriores
        foreach ($request->detalles_venta as $detalle) {
            Detalle_Venta::create([
                'id_venta' => $venta->id_venta,
                'id_suplemento' => $detalle['id_suplemento'],
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['precio'],
            ]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    // Eliminar una venta
    public function destroy(Venta $venta)
    {
        // Eliminar los detalles de la venta
        $venta->detallesVentas()->delete();

        // Eliminar la venta
        $venta->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
    public function detalles($id_venta)
{
    $venta = Venta::findOrFail($id_venta);
    $suplementos = Suplemento::all();

    return view('ventas.detalles', compact('venta', 'suplementos'));
}

public function storeDetalles(Request $request, $id_venta)
{
    // Validación de los datos
    $validatedData = $request->validate([
        'detalles_venta' => 'required|array',
        'detalles_venta.*.id_suplemento' => 'required|exists:suplementos,id_suplemento',
        'detalles_venta.*.cantidad' => 'required|integer|min:1',
        'detalles_venta.*.precio' => 'required|numeric|min:0',
    ]);

    // Obtener la venta
    $venta = Venta::findOrFail($id_venta);

    // Inicializar el monto total
    $total = 0;

    // Crear los detalles de la venta
    foreach ($request->detalles_venta as $detalle) {
        Detalle_Venta::create([
            'id_venta' => $venta->id_venta,
            'id_suplemento' => $detalle['id_suplemento'],
            'cantidad' => $detalle['cantidad'],
            'precio' => $detalle['precio'],
        ]);

        // Sumar al total
        $total += $detalle['cantidad'] * $detalle['precio'];
    }

    // Actualizar el monto de la venta
    $venta->update(['monto' => $total]);

    // Redirigir a la página de ventas con el monto actualizado
    return redirect()->route('ventas.index')->with('success', 'Detalles de venta registrados correctamente.');
}

}
