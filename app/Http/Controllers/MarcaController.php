<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarcaController extends Controller
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
    }    public function index()
    {
        $marcas = Marca::paginate(10); // 10 items por página (ajusta según necesites)
        return view('marcas.index', compact('marcas'));
    }

    // Mostrar formulario para crear una nueva marca
    public function create()
    {
        return view('marcas.create');
    }

    // Guardar una nueva marca
    public function store(Request $request)
    {
        $request->validate([
            'nom_marca' => 'required|string|max:255',
        ]);

        Marca::create($request->all());

        return redirect()->route('marcas.index')
                         ->with('register', 'La marca ha sido creada exitosamente.');
    }

    // Mostrar los detalles de una marca seleccionada
    public function show($id)
    {
        $marca = Marca::findOrFail($id);
        return view('marcas.show', compact('marca'));
    }

    // Mostrar formulario para editar una marca
    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        return view('marcas.edit', compact('marca'));
    }

    // Actualizar una marca existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_marca' => 'required|string|max:255',
        ]);

        $marca = Marca::findOrFail($id);
        $marca->update($request->all());

        return redirect()->route('marcas.index')
                         ->with('modify', 'La marca ha sido actualizada exitosamente.');
    }

    // Eliminar una marca
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();

        return redirect()->route('marcas.index')
                         ->with('destroy', 'La marca ha sido eliminada exitosamente.');
    }
}
