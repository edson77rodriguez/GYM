<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GestionProveedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->persona->rol->id_rol == 2 || Auth::user()->persona->rol->id_rol == 4) {
                return response()->view('denegado', [], 403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $proveedores = Proveedor::with('persona')->latest()->get();
        return view('GPM.index', compact('proveedores'));
    }
    public function edit($id)
    {
        $proveedor = Proveedor::with('persona')->findOrFail($id);
        return response()->json($proveedor);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'ap' => 'required|string|max:255',
            'am' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:20|unique:personas,telefono',
            'correo' => 'required|email|unique:personas,correo',
            'contrasena' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $persona = Persona::create([
                'nom' => $request->nom,
                'ap' => $request->ap,
                'am' => $request->am,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'contrasena' => Hash::make($request->contrasena),
                'id_rol' => 4,
            ]);

            $proveedor = Proveedor::create(['id_persona' => $persona->id_persona]);

            return response()->json([
                'success' => true,
                'message' => 'Proveedor creado exitosamente',
                'proveedor' => $proveedor->load('persona')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el proveedor'
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'edit_nom' => 'required|string|max:255',
            'edit_ap' => 'required|string|max:255',
            'edit_am' => 'nullable|string|max:255',
            'edit_telefono' => 'required|string|max:20|unique:personas,telefono,'.$proveedor->persona->id_persona.',id_persona',
            'edit_correo' => 'required|email|unique:personas,correo,'.$proveedor->persona->id_persona.',id_persona',
            'edit_contrasena' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $personaData = [
                'nom' => $request->edit_nom,
                'ap' => $request->edit_ap,
                'am' => $request->edit_am,
                'telefono' => $request->edit_telefono,
                'correo' => $request->edit_correo,
            ];

            if ($request->filled('edit_contrasena')) {
                $personaData['contrasena'] = Hash::make($request->edit_contrasena);
            }

            $proveedor->persona->update($personaData);

            return response()->json([
                'success' => true,
                'message' => 'Proveedor actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proveedor'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $persona = $proveedor->persona;
            
            $proveedor->delete();
            $persona->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proveedor'
            ], 500);
        }
    }
}