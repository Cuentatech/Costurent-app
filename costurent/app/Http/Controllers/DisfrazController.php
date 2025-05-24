<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disfraz;
use App\Models\Categoria;

class DisfrazController extends Controller
{
    // Listar todos los disfraces
    public function index()
    {
        $disfraces = Disfraz::with('categoria')->get();
        return view('admin.disfraces.index', compact('disfraces'));
    }

    // Mostrar formulario para crear nuevo disfraz
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.disfraces.create', compact('categorias'));
    }

    // Guardar nuevo disfraz
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'cantidad_total' => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
        ]);

        Disfraz::create($request->all());

        return redirect()->route('disfraces.index')->with('success', 'Disfraz creado con éxito.');
    }

    // Mostrar formulario para editar un disfraz
    public function edit($id)
    {
        $disfraz = Disfraz::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.disfraces.edit', compact('disfraz', 'categorias'));
    }

    // Actualizar disfraz
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'cantidad_total' => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
        ]);

        $disfraz = Disfraz::findOrFail($id);
        $disfraz->update($request->all());

        return redirect()->route('disfraces.index')->with('success', 'Disfraz actualizado con éxito.');
    }

    // Eliminar disfraz
    public function destroy($id)
    {
        $disfraz = Disfraz::findOrFail($id);
        $disfraz->delete();

        return redirect()->route('disfraces.index')->with('success', 'Disfraz eliminado con éxito.');
    }
}
