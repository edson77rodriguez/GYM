<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // Mostrar todos los planes
    public function index()
    {
        $planes = Plan::all();
        return view('planes.index', compact('planes'));
    }

    // Mostrar formulario para crear un nuevo plan
    public function create()
    {
        return view('planes.create');
    }

    // Guardar un nuevo plan
    public function store(Request $request)
    {
        $request->validate([
            'nom_plan' => 'required|string|max:50|unique:planes,nom_plan',
            'desc_plan' => 'required|string',
            'costo' => 'required|numeric|min:0',
        ]);

        Plan::create($request->all());

        return redirect()->route('planes.index')
                         ->with('success', 'Plan creado exitosamente.');
    }

    // Mostrar el plan seleccionado
    public function show($id)
    {
        $plan = Plan::findOrFail($id);
        return view('planes.show', compact('plan'));
    }

    // Mostrar formulario para editar un plan
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('planes.edit', compact('plan'));
    }

    // Actualizar un plan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_plan' => 'required|string|max:50|unique:planes,nom_plan,' . $id,
            'desc_plan' => 'required|string',
            'costo' => 'required|numeric|min:0',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update($request->all());

        return redirect()->route('planes.index')
                         ->with('success', 'Plan actualizado exitosamente.');
    }

    // Eliminar un plan
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()->route('planes.index')
                         ->with('success', 'Plan eliminado exitosamente.');
    }
}
