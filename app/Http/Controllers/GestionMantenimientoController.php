<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Equipo;
use App\Models\Empleado;
use Illuminate\Http\Request;

class GestionMantenimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = Mantenimiento::with(['equipo', 'empleado.persona'])
            ->orderBy('fecha_programada', 'desc')
            ->get();
            
        $equipos = Equipo::all();
        $empleados = Empleado::with('persona')->get();
        
        return view('gestion_mantenimiento.index', compact('mantenimientos', 'equipos', 'empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_equipo' => 'required|exists:equipos,id_equipo',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'fecha_programada' => 'required|date',
            'desc_estado' => 'required|string|max:255',
        ]);

        Mantenimiento::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mantenimiento creado correctamente'
        ]);
    }

    public function show(Mantenimiento $mantenimiento)
    {
        return response()->json([
            'success' => true,
            'data' => $mantenimiento->load(['equipo', 'empleado.persona'])
        ]);
    }

    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $request->validate([
            'id_equipo' => 'required|exists:equipos,id_equipo',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'fecha_programada' => 'required|date',
            'desc_estado' => 'required|string|max:255',
        ]);

        $mantenimiento->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mantenimiento actualizado correctamente'
        ]);
    }

    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mantenimiento eliminado correctamente'
        ]);
    }

    public function calendar()
    {
        $mantenimientos = Mantenimiento::with(['equipo', 'empleado.persona'])
            ->get()
            ->map(function($item) {
                return [
                    'title' => $item->equipo->nom_equipo . ' - ' . $item->empleado->persona->nom,
                    'start' => $item->fecha_programada,
                    'url' => route('gestion-mantenimiento.show', $item->id_mantenimiento),
                    'backgroundColor' => $this->getStatusColor($item->desc_estado),
                ];
            });

        return view('gestion_mantenimiento.calendar', compact('mantenimientos'));
    }

    private function getStatusColor($status)
    {
        switch(strtolower($status)) {
            case 'pendiente': return '#ffc107';
            case 'en progreso': return '#17a2b8';
            case 'completado': return '#28a745';
            case 'cancelado': return '#dc3545';
            default: return '#6c757d';
        }
    }
}