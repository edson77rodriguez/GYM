<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // Mostrar la vista con todas las categorías
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nom_cat' => 'required|string|max:255',
        ]);

        Categoria::create($request->only('nom_cat'));

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    // Editar una categoría
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_cat' => 'required|string|max:255',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->only('nom_cat'));

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    // Eliminar una categoría
    public function destroy($id)
    {
        Categoria::findOrFail($id)->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
