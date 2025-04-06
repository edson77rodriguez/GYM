<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Persona;
use App\Models\Estado_Membresia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

class GestionSociosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->persona->rol->nom_rol == 'Administrador' && Auth::user()->persona->rol->nom_rol == 'Empleado') {
                return response()->view('denegado', [], 403);
            }
            return $next($request);
        });
    }    public function index()
    {
        $socios = Socio::all();
        $personas = Persona::all();
        $estados = Estado_Membresia::all();
        $user = auth()->user();
        $planes = Plan::all();
        return view('GSM.index', compact('socios', 'personas', 'estados','user','planes'));
    }

    // Guardar un nuevo socio
    public function store(Request $request)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'ap' => 'required|string|max:255',
        'am' => 'nullable|string|max:255',
        'telefono' => 'required|string|max:20',
        'correo' => 'required|email|unique:personas,correo',
        'fecha_inscripcion' => 'required|date',
    ]);

    // Buscar el ID del rol "Socio"
    $rolSocio = \App\Models\Rol::where('desc_rol', 'Socio')->first();
    if (!$rolSocio) {
        return redirect()->back()->with('error', 'No se encontró el rol de Socio.');
    }

    // Crear la persona y asignarle el rol de socio
    $persona = \App\Models\Persona::create([
        'nom' => $validatedData['nom'],
        'ap' => $validatedData['ap'],
        'am' => $validatedData['am'],
        'telefono' => $validatedData['telefono'],
        'correo' => $validatedData['correo'],
        'contrasena' => bcrypt('password123'), // Contraseña por defecto
        'id_rol' => $rolSocio->id_rol,
    ]);

    // Crear el socio con la persona recién creada
    Socio::create([
        'id_persona' => $persona->id_persona,
        'fecha_inscripcion' => $validatedData['fecha_inscripcion'],
        'fecha_vencimiento' => Carbon::now()->addDay(), // Fecha de vencimiento inicial
        'id_estado_mem' => 1, // Estado inhabilitado por defecto
    ]);

    return redirect()->route('GSM.index')->with('success', 'Socio creado correctamente.');
}

}
