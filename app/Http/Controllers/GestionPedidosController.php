<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Proveedor;
use App\Models\Suplemento;
use Illuminate\Http\Request;

class GestionPedidosController extends Controller
{
    public function index()
    {
        // Obtener todos los pedidos con sus relaciones
        $pedidos = Pedido::with('proveedor', 'suplemento')->get();
        $proveedores = Proveedor::all();
        $suplementos = Suplemento::all();

        return view('GESP.index', compact('pedidos', 'proveedores', 'suplementos'));
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer',
            'fecha_pedido' => 'required|date',
        ]);

        // Crear un nuevo pedido
        Pedido::create([
            'id_proveedor' => $request->id_proveedor,
            'id_suplemento' => $request->id_suplemento,
            'cantidad' => $request->cantidad,
            'fecha_pedido' => $request->fecha_pedido,
        ]);

        return redirect()->route('GESP.index')->with('register', 'El pedido ha sido creado.');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer|min:1',
            'stock_disponible' => 'required|integer|min:0',
            'fecha_pedido' => 'required|date',
        ]);

        // Encontrar el pedido por ID
        $pedido = Pedido::findOrFail($id);

        // Actualizar los datos del pedido
        $pedido->id_proveedor = $request->id_proveedor;
        $pedido->id_suplemento = $request->id_suplemento;
        $pedido->cantidad = $request->cantidad;
        $pedido->fecha_pedido = $request->fecha_pedido;

        // Actualizar el stock del suplemento
        $suplemento = Suplemento::find($request->id_suplemento);

        // Verificar si el stock es suficiente antes de actualizar
        if ($suplemento->stock >= $request->cantidad) {
            $suplemento->stock -= $request->cantidad; // Resta la cantidad solicitada del stock
            $suplemento->save();
        } else {
            return redirect()->route('GESP.index')->with('error', 'Stock insuficiente.');
        }

        // Guardar el pedido actualizado
        $pedido->save();

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('GESP.index')->with('modify', 'Pedido actualizado correctamente');
    }

    public function destroy($id)
    {
        // Eliminar el pedido
        Pedido::destroy($id);

        return redirect()->route('GESP.index')->with('destroy', 'El pedido ha sido eliminado.');
    }
}
