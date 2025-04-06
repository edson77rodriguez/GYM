<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EquipoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->persona->rol->nom_rol !== 'Administrador') {
                return response()->view('denegado', [], 403);
            }
            return $next($request);
        });
    }
    public function index()
    {
        // Obtener todos los equipos
        $equipos = Equipo::all();
        return view('equipos.index', compact('equipos'));
    }

    public function store(Request $request)
    {
        // Validar los datos enviados por el formulario
        $validatedData = $request->validate([
            'nom_equipo' => 'required|max:255',
            'desc_equipo' => 'nullable|string',
            'imagen_equipo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Si hay una imagen, la guardamos
        if ($request->hasFile('imagen_equipo')) {
            $validatedData['imagen_equipo'] = $request->file('imagen_equipo')->store('images', 'public');
        }

        // Crear el nuevo equipo en la base de datos
        Equipo::create($validatedData);

        return redirect()->route('equipos.index')->with('success', 'Equipo creado correctamente.');
    }

    public function update(Request $request, Equipo $equipo)
    {
        // Validar los datos enviados por el formulario
        $validatedData = $request->validate([
            'nom_equipo' => 'required|max:255',
            'desc_equipo' => 'nullable|string',
            'imagen_equipo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Si hay una imagen, eliminamos la anterior y guardamos la nueva
        if ($request->hasFile('imagen_equipo')) {
            if ($equipo->imagen_equipo) {
                Storage::delete('public/' . $equipo->imagen_equipo);
            }
            $validatedData['imagen_equipo'] = $request->file('imagen_equipo')->store('images', 'public');
        }

        // Actualizar el equipo
        $equipo->update($validatedData);

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo)
    {
        // Eliminar la imagen del equipo si existe
        if ($equipo->imagen_equipo) {
            Storage::delete('public/' . $equipo->imagen_equipo);
        }

        // Eliminar el equipo de la base de datos
        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado correctamente.');
    }
}
