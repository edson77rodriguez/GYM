<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Equipo;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MantenimientoController extends Controller
{
    // Mostrar lista de mantenimientos
    public function index()
    {
        $mantenimientos = Mantenimiento::with(['equipo', 'empleado'])->get();
        $equipos = Equipo::all();
        $empleados = Empleado::all();
        return view('mantenimientos.index', compact('mantenimientos', 'equipos', 'empleados'));
    }

    // Guardar un nuevo mantenimiento
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_equipo' => 'required|exists:equipos,id_equipo',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'fecha_programada' => 'required|date',
            'desc_estado' => 'nullable|string',
        ]);

        Mantenimiento::create($validatedData);

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento creado correctamente.');
    }

    // Actualizar un mantenimiento
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $validatedData = $request->validate([
            'id_equipo' => 'required|exists:equipos,id_equipo',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'fecha_programada' => 'required|date',
            'desc_estado' => 'nullable|string',
        ]);

        $mantenimiento->update($validatedData);

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento actualizado correctamente.');
    }

    // Eliminar un mantenimiento
    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->delete();

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento eliminado correctamente.');
    }
}
