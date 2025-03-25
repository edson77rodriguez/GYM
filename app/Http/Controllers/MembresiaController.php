<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membresia;
use App\Models\Socio;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;

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
    public function storee(Request $request)
    {
        \Log::info('Datos recibidos:', $request->all());
    
        // Validación
        $request->validate([
            'id_socio' => 'required|exists:socios,id_socio',
            'id_plan' => 'required|exists:planes,id_plan',
        ]);
    
        // Obtener el plan seleccionado
        $plan = Plan::findOrFail($request->id_plan);
        $costo = $plan->costo;
        $fechaInicio = Carbon::now(); // Fecha de inicio hoy
    
        // Calcular la fecha de vencimiento según el plan
        switch ($plan->nom_plan) {
            case 'Plan Mensual':
                $fechaFin = $fechaInicio->copy()->addMonth();
                break;
            case 'Plan Bimestral':
                $fechaFin = $fechaInicio->copy()->addMonths(2);
                break;
            case 'Plan Trimestral':
                $fechaFin = $fechaInicio->copy()->addMonths(3);
                break;
            case 'Plan Semestral':
                $fechaFin = $fechaInicio->copy()->addMonths(6);
                break;
            case 'Plan Anual':
                $fechaFin = $fechaInicio->copy()->addYear();
                break;
            default:
                $fechaFin = $fechaInicio->copy()->addDay(); // Por seguridad, sumamos un día
                break;
        }
    
        // Crear la membresía con la fecha de vencimiento correcta
        Membresia::create([
            'id_socio' => $request->id_socio,
            'id_plan' => $request->id_plan,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin, // Se asigna la fecha de vencimiento manualmente
            'costo' => $costo,
        ]);
    
        // Buscar el id del estado 'Activo' en la tabla estados_membresias
        $estadoActivo = DB::table('estados_membresias')
            ->where('nom_estado', 'Activo')
            ->first();
    
        if ($estadoActivo) {
            // Obtener el id_estado_mem
            $id_estado_mem = $estadoActivo->id_estado_mem;
    
            // Actualizar la fecha de inscripción y vencimiento del socio
            $socio = Socio::findOrFail($request->id_socio);
            $socio->update([
                'fecha_inscripcion' => $fechaInicio,
                'fecha_vencimiento' => $fechaFin,
                'id_estado_mem' => $id_estado_mem, // Asignar el id de estado 'Activo'
            ]);
        } else {
            return redirect()->route('GSM.index')->with('error', 'Estado "Activo" no encontrado.');
        }
    
        return redirect()->route('GSM.index')->with('success', 'Membresía asignada correctamente.');
    }
    
}
