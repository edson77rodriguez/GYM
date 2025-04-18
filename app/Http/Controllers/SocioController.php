<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Persona;
use App\Models\Estado_Membresia;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;

class SocioController extends Controller
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
        $socios = Socio::all();
        $personas = Persona::all();
        $estados = Estado_Membresia::all();
        return view('socios.index', compact('socios', 'personas', 'estados'));
    }

    // Guardar un nuevo socio
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'fecha_inscripcion' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'id_estado_mem' => 'required|exists:estados_membresias,id_estado_mem',
        ]);

        Socio::create($validatedData);

        return redirect()->route('socios.index')->with('success', 'Socio creado correctamente.');
    }

    // Actualizar un socio
    public function update(Request $request, Socio $socio)
    {
        $validatedData = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'fecha_inscripcion' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'id_estado_mem' => 'required|exists:estados_membresias,id_estado_mem',
        ]);

        $socio->update($validatedData);

        return redirect()->route('socios.index')->with('success', 'Socio actualizado correctamente.');
    }

    // Eliminar un socio
    public function destroy(Socio $socio)
    {
        $socio->delete();

        return redirect()->route('socios.index')->with('success', 'Socio eliminado correctamente.');
    }
}
