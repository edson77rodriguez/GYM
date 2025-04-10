<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log; // Recomendado para el logging
use Illuminate\Support\Facades\DB; // Añade esta línea

use App\Models\Pedido;
use App\Models\Proveedor;
use App\Models\Suplemento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;
use App\Models\Marca;
use Carbon\Carbon;

class GestionPedidosController extends Controller
{
    public function recibir(Pedido $pedido)
{
    try {
        DB::beginTransaction();
        
        // Marcar el pedido como recibido
        $pedido->update(['recibido' => true]);
        
        // Actualizar el stock del suplemento
        $suplemento = $pedido->suplemento;
        $suplemento->increment('stock', $pedido->cantidad);
        
        DB::commit();
        
        return redirect()->route('GESP.index')
            ->with('success', 'Pedido marcado como recibido y stock actualizado');
            
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al recibir pedido: ' . $e->getMessage());
        
        return redirect()->route('GESP.index')
            ->with('error', 'Error al procesar el pedido');
    }
}
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->persona->rol->id_rol == 2 || Auth::user()->persona->rol->id_rol == 4 ) {
                return response()->view('denegado', [], 403);
            }
            return $next($request);
        });
    }
    public function index()
    {
        $pedidos = Pedido::with(['proveedor.persona', 'suplemento'])
                    ->orderBy('fecha_pedido', 'desc')
                    ->get();
        
        $proveedores = Proveedor::with('persona')->get();
        $suplementos = Suplemento::all(); // O with(['categoria']) si lo necesitas
        
        return view('GESP.index', compact('pedidos', 'proveedores', 'suplementos'));
    }

public function search(Request $request)
{
    $query = Pedido::with(['proveedor.persona', 'suplemento']);
    
    if ($request->filled('proveedor')) {
        $query->where('id_proveedor', $request->proveedor);
    }
    
    if ($request->filled('suplemento')) {
        $query->where('id_suplemento', $request->suplemento);
    }
    
    if ($request->filled('fecha_inicio')) {
        $query->where('fecha_pedido', '>=', $request->fecha_inicio);
    }
    
    if ($request->filled('fecha_fin')) {
        $query->where('fecha_pedido', '<=', $request->fecha_fin);
    }
    
    $pedidos = $query->get();
    
    return view('GESP._pedidos_table', compact('pedidos'));
}
public function checkLowStock()
{
    $suplementos = Suplemento::where('stock', '<', 10)->get();
    return response()->json($suplementos);
}
public function store(Request $request)
{
    // Validación de datos con mensajes personalizados
    $validatedData = $request->validate([
        'id_proveedor' => 'required|exists:proveedores,id_proveedor',
        'id_suplemento' => 'required|exists:suplementos,id_suplemento',
        'cantidad' => 'required|integer|min:1|max:999',
        'fecha_pedido' => 'required|date|after_or_equal:today'
    ], [
        'cantidad.min' => 'La cantidad mínima debe ser 1',
        'cantidad.max' => 'La cantidad máxima permitida es 999',
        'fecha_pedido.after_or_equal' => 'No se permiten fechas anteriores al día actual'
    ]);

    try {
        // Creación del pedido usando Carbon para la fecha
        $pedido = new Pedido();
        $pedido->id_proveedor = $validatedData['id_proveedor'];
        $pedido->id_suplemento = $validatedData['id_suplemento'];
        $pedido->cantidad = $validatedData['cantidad'];
        $pedido->fecha_pedido = Carbon::parse($validatedData['fecha_pedido']);
        $pedido->save();

        // Opcional: Registrar en log
        \Log::info("Nuevo pedido creado: ID {$pedido->id_pedido}", [
            'proveedor' => $pedido->id_proveedor,
            'suplemento' => $pedido->id_suplemento,
            'cantidad' => $pedido->cantidad
        ]);

        return redirect()
            ->route('GESP.index')
            ->with('success', 'Pedido registrado correctamente.');

    } catch (\Exception $e) {
        \Log::error('Error al crear pedido: ' . $e->getMessage());
        
        return back()
            ->withInput()
            ->with('error', 'Ocurrió un error al registrar el pedido. Por favor intente nuevamente.');
    }
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

        return redirect()->route('GESP.index')->with('modify', 'El pedido ha sido actualizado.');
    }

    public function destroy($id)
    {
        // Eliminar el pedido
        Pedido::destroy($id);

        return redirect()->route('GESP.index')->with('destroy', 'El pedido ha sido eliminado.');
    }
}
