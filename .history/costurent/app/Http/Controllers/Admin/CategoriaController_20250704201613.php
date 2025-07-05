<?php

namespace App\Http\Controllers  ;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Controllers\Controller;

class CategoriaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('admin.disfraces.index')->with('success', 'Categoría creada con éxito.');
    }
}