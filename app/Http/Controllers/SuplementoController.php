<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suplemento;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;

class SuplementoController extends Controller
{
    public function index()
    {
        
        $suplementos = Suplemento::all();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('suplementos.index', compact('suplementos', 'categorias', 'marcas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom_suplemento' => 'required|max:255',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_marca' => 'required|exists:marcas,id_marca',
            'desc_suplemento' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen_suplemento' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('imagen_suplemento')) {
            $validatedData['imagen_suplemento'] = $request->file('imagen_suplemento')->store('images', 'public');
        }

        Suplemento::create($validatedData);

        return redirect()->route('suplementos.index')->with('success', 'Suplemento creado correctamente.');
    }

    public function update(Request $request, Suplemento $suplemento)
    {
        $validatedData = $request->validate([
            'nom_suplemento' => 'required|max:255',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_marca' => 'required|exists:marcas,id_marca',
            'desc_suplemento' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen_suplemento' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('imagen_suplemento')) {
            if ($suplemento->imagen_suplemento) {
                Storage::delete('public/' . $suplemento->imagen_suplemento);
            }
            $validatedData['imagen_suplemento'] = $request->file('imagen_suplemento')->store('images', 'public');
        }

        $suplemento->update($validatedData);

        return redirect()->route('suplementos.index')->with('success', 'Suplemento actualizado correctamente.');
    }

    public function destroy(Suplemento $suplemento)
    {
        if ($suplemento->imagen_suplemento) {
            Storage::delete('public/' . $suplemento->imagen_suplemento);
        }

        $suplemento->delete();

        return redirect()->route('suplementos.index')->with('success', 'Suplemento eliminado correctamente.');
    }
}
