<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Persona;
use App\Models\Estado_Membresia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GestionSociosController extends Controller
{
    // Mostrar lista de socios
    public function index()
    {
        $socios = Socio::all();
        $personas = Persona::all();
        $estados = Estado_Membresia::all();
        $user = auth()->user();

        return view('GSM.index', compact('socios', 'personas', 'estados','user'));
    }

    // Guardar un nuevo socio
    public function store(Request $request)
    {
        // Validación
        $validatedData = $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'fecha_inscripcion' => 'required|date',
        ]);

        // Establecer la fecha de vencimiento como 0000-00-00 y el estado de membresía a 1 (inhabilitado)
// Establecer la fecha de vencimiento como el siguiente día
$validatedData['fecha_vencimiento'] = Carbon::now()->addDay(); // Añadir un día a la fecha actual
        $validatedData['id_estado_mem'] = 1;  // Estado inhabilitado

        // Crear el nuevo socio
        Socio::create($validatedData);

        return redirect()->route('GSM.index')->with('success', 'Socio creado correctamente.');
    }
}
