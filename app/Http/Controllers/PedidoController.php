<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Proveedor;
use App\Models\Suplemento;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->persona->rol->id_rol !== 1) {
                return response()->view('denegado', [], 403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $pedidos = Pedido::with(['proveedor.persona', 'suplemento'])
                       ->orderBy('fecha_pedido', 'desc')
                       ->paginate(8); // 8 items por página

        $proveedores = Proveedor::with('persona')->get();
        $suplementos = Suplemento::all();

        return view('pedidos.index', compact('pedidos', 'proveedores', 'suplementos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer|min:1',
            'fecha_pedido' => 'required|date',
        ]);

        Pedido::create($validatedData);

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido creado correctamente.');
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validatedData = $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_suplemento' => 'required|exists:suplementos,id_suplemento',
            'cantidad' => 'required|integer|min:1',
            'fecha_pedido' => 'required|date',
        ]);

        $pedido->update($validatedData);

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido eliminado correctamente.');
    }
}