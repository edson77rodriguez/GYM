<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Proveedor;
use App\Models\Suplemento;

class PedidoController extends Controller
{
    public function index()
    {
        // Obtén todos los pedidos y los proveedores y suplementos para mostrarlos en la vista
        $pedidos = Pedido::all();
        $proveedores = Proveedor::all();
        $suplementos = Suplemento::all();

        return view('pedidos.index', compact('pedidos', 'proveedores', 'suplementos'));
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer|min:1',
            'fecha_pedido' => 'required|date',
        ]);

        // Crear el pedido
        Pedido::create($validatedData);

        // Redirigir con un mensaje de éxito
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado correctamente.');
    }

    public function update(Request $request, Pedido $pedido)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer|min:1',
            'fecha_pedido' => 'required|date',
        ]);

        // Actualizar el pedido
        $pedido->update($validatedData);

        // Redirigir con un mensaje de éxito
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        // Eliminar el pedido
        $pedido->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
