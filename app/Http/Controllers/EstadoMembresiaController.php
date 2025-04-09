<?php

namespace App\Http\Controllers;

use App\Models\Estado_Membresia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstadoMembresiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->persona->rol->id_rol == 2 || Auth::user()->persona->rol->id_rol == 4 ) {
                return response()->view('denegado', [], 403);
            }
            return $next($request);
        });
    }     public function index()
      {
          $estadosMembresias = Estado_Membresia::all();
          return view('estado_membresias.index', compact('estadosMembresias'));
      }
  
      // Mostrar formulario para crear un nuevo estado de membresía
      public function create()
      {
          return view('estado_membresias.create');
      }
  
      // Guardar un nuevo estado de membresía
      public function store(Request $request)
      {
          $request->validate([
              'nom_estado' => 'required|string|max:255',
          ]);
  
          Estado_Membresia::create($request->all());
  
          return redirect()->route('estado_membresias.index')
                           ->with('success', 'Estado de membresía creado exitosamente.');
      }
  
      // Mostrar el estado de membresía seleccionado
      public function show($id)
      {
          $estadoMembresia = Estado_Membresia::findOrFail($id);
          return view('estado_membresias.show', compact('estadoMembresia'));
      }
  
      // Mostrar formulario para editar un estado de membresía
      public function edit($id)
      {
          $estadoMembresia = Estado_Membresia::findOrFail($id);
          return view('estado_membresias.edit', compact('estadoMembresia'));
      }
  
      // Actualizar un estado de membresía
      public function update(Request $request, $id)
      {
          $request->validate([
              'nom_estado' => 'required|string|max:255',
          ]);
  
          $estadoMembresia = Estado_Membresia::findOrFail($id);
          $estadoMembresia->update($request->all());
  
          return redirect()->route('estado_membresias.index')
                           ->with('success', 'Estado de membresía actualizado exitosamente.');
      }
  
      // Eliminar un estado de membresía
      public function destroy($id)
      {
          $estadoMembresia = Estado_Membresia::findOrFail($id);
          $estadoMembresia->delete();
  
          return redirect()->route('estado_membresias.index')
                           ->with('success', 'Estado de membresía eliminado exitosamente.');
      }
}
