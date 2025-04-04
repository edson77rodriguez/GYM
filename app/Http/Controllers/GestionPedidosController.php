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
        $pedidos = Pedido::with('proveedor.persona', 'suplemento')->get();
        $proveedores = Proveedor::with('persona')->get();
        $suplementos = Suplemento::all();

        return view('pedidos.index', compact('pedidos', 'proveedores', 'suplementos'));
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

        return redirect()->route('pedidos.index')->with('register', 'El pedido ha sido creado.');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer',
            'fecha_pedido' => 'required|date',
        ]);

        // Encontrar el pedido por su ID y actualizarlo
        $pedido = Pedido::findOrFail($id);
        $pedido->update([
            'id_proveedor' => $request->id_proveedor,
            'id_suplemento' => $request->id_suplemento,
            'cantidad' => $request->cantidad,
            'fecha_pedido' => $request->fecha_pedido,
        ]);

        return redirect()->route('pedidos.index')->with('modify', 'El pedido ha sido actualizado.');
    }

    public function destroy($id)
    {
        // Eliminar el pedido
        Pedido::destroy($id);

        return redirect()->route('pedidos.index')->with('destroy', 'El pedido ha sido eliminado.');
    }
}
