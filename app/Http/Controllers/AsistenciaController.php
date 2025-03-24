<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Socio;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    // Mostrar todas las asistencias
    public function index()
    {
        $asistencias = Asistencia::with('socio')->get();
        $socios = Socio::all();

        return view('asistencias.index', compact('asistencias', 'socios'));
    }

    // Almacenar una nueva asistencia (hora de entrada)
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'fecha_asi' => 'required|date',
        ]);

        // Crear la asistencia y establecer la hora de entrada
        $validatedData['hora_entrada'] = Carbon::now()->format('H:i:s');

        // Crear la asistencia
        Asistencia::create($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente.');
    }

    // Actualizar una asistencia (hora de salida)
    public function update(Request $request, Asistencia $asistencia)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'fecha_asi' => 'required|date',
        ]);

        // Actualizar la hora de salida
        $validatedData['hora_salida'] = Carbon::now()->format('H:i:s');

        // Actualizar la asistencia
        $asistencia->update($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    // Eliminar una asistencia
    public function destroy(Asistencia $asistencia)
    {
        // Eliminar la asistencia
        $asistencia->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }
}
