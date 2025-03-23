<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membresia;
use App\Models\Socio;
use App\Models\Plan;
use Carbon\Carbon; 
class MembresiaController extends Controller
{
    // Mostrar lista de membresías
    public function index()
    {
        $membresias = Membresia::with(['socio', 'plan'])->get();
        $socios = Socio::all();
        $planes = Plan::all();
        foreach ($membresias as $membresia) {
            $membresia->fecha_inicio = Carbon::parse($membresia->fecha_inicio);
            $membresia->fecha_fin = Carbon::parse($membresia->fecha_fin);
        }
        return view('membresias.index', compact('membresias', 'socios', 'planes'));
    }

    // Guardar una nueva membresía
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'id_plan' => 'required|exists:planes,id_plan',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'costo' => 'required|numeric|min:0.01',
        ]);

        Membresia::create($validatedData);

        return redirect()->route('membresias.index')->with('success', 'Membresía creada correctamente.');
    }

    // Actualizar una membresía
    public function update(Request $request, Membresia $membresia)
    {
        $validatedData = $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'id_plan' => 'required|exists:planes,id_plan',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'costo' => 'required|numeric|min:0.01',
        ]);

        $membresia->update($validatedData);

        return redirect()->route('membresias.index')->with('success', 'Membresía actualizada correctamente.');
    }

    // Eliminar una membresía
    public function destroy(Membresia $membresia)
    {
        $membresia->delete();

        return redirect()->route('membresias.index')->with('success', 'Membresía eliminada correctamente.');
    }
}
