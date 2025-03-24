<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Persona;

class ProveedorController extends Controller
{
    // Mostrar todos los proveedores
    public function index()
    {
        $proveedores = Proveedor::with('persona')->get();
        $personas = Persona::all();

        return view('proveedores.index', compact('proveedores', 'personas'));
    }

    // Almacenar un nuevo proveedor
    public function store(Request $request)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
        ]);

        // Crear el proveedor
        Proveedor::create($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado correctamente.');
    }

    // Actualizar un proveedor
    public function update(Request $request, Proveedor $proveedor)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
        ]);

        // Actualizar el proveedor
        $proveedor->update($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    // Eliminar un proveedor
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }


}
