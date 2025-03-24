<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Disponibilidad;

class EmpleadoController extends Controller
{
    // Mostrar todos los empleados
    public function index()
    {
        // Obtener todos los empleados con sus relaciones
        $empleados = Empleado::with(['persona', 'disponibilidad'])->get();
        $personas = Persona::all();
        $disponibilidades = Disponibilidad::all();

        return view('empleados.index', compact('empleados', 'personas', 'disponibilidades'));
    }

    // Almacenar un nuevo empleado
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'id_disponibilidad' => 'required|exists:disponibilidades,id_disponibilidad',
        ]);

        // Crear el empleado
        Empleado::create($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
    }

    // Actualizar un empleado
    public function update(Request $request, Empleado $empleado)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'id_disponibilidad' => 'required|exists:disponibilidades,id_disponibilidad',
        ]);

        // Actualizar los datos del empleado
        $empleado->update($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    // Eliminar un empleado
    public function destroy(Empleado $empleado)
    {
        // Eliminar el empleado
        $empleado->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
