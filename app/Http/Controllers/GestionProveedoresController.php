<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class GestionProveedoresController extends Controller
{
    // Mostrar lista de proveedores
    public function index()
    {
        $proveedores = Proveedor::all();
        $personas = Persona::all();
        $user = auth()->user();

        return view('GPM.index', compact('proveedores', 'personas', 'user'));
    }

    // Guardar un nuevo proveedor
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'ap' => 'required|string|max:255',
            'am' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|unique:personas,correo',
            'contrasena' => 'required|string|min:8', // Permite que el usuario ingrese una contraseña
        ]);

        // Crear la persona y asignarle el rol de proveedor (ID fijo = 4)
        $persona = Persona::create([
            'nom' => $validatedData['nom'],
            'ap' => $validatedData['ap'],
            'am' => $validatedData['am'],
            'telefono' => $validatedData['telefono'],
            'correo' => $validatedData['correo'],
            'contrasena' => Hash::make($validatedData['contrasena']), // Hashea la contraseña ingresada
            'id_rol' => 4, // ID fijo para el rol de Proveedor
        ]);

        // Crear el proveedor con la persona recién creada
        Proveedor::create([
            'id_persona' => $persona->id_persona,
        ]);

        return redirect()->route('GPM.index')->with('success', 'Proveedor creado correctamente.');
    }
}
