<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Disfraz;
use App\Models\Categoria;

class DisfrazController extends Controller
{
    // Mostrar todos los disfraces
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        $query = Disfraz::with('categoria');

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $disfraces = $query->orderBy('id', 'desc')->get();

        return view('admin.disfraces.index', compact('disfraces', 'categorias'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.disfraces.create', compact('categorias'));
    }

    // Guardar nuevo disfraz
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'cantidad_total' => 'required|integer',
            'cantidad_disponible' => 'required|integer',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $datos = $request->all();

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('disfraces', 'public');
        }

        Disfraz::create($datos);

        return redirect()->route('admin.disfraces.index')->with('success', 'Disfraz creado con imagen correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $disfraz = Disfraz::findOrFail($id);
        $disfraces = Disfraz::with('categoria')->get();
        $categorias = \App\Models\Categoria::all();

        return view('admin.disfraces.index', compact('disfraz', 'disfraces', 'categorias'));
    }

    // Actualizar disfraz
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'cantidad_total' => 'required|integer',
            'cantidad_disponible' => 'required|integer',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $disfraz = Disfraz::findOrFail($id);
        $datos = $request->all();

        if ($request->hasFile('imagen')) {
            // Opcional: eliminar la imagen anterior
            if ($disfraz->imagen && Storage::disk('public')->exists($disfraz->imagen)) {
                Storage::disk('public')->delete($disfraz->imagen);
            }

            $datos['imagen'] = $request->file('imagen')->store('disfraces', 'public');
        }

        $disfraz->update($datos);

        return redirect()->route('admin.disfraces.index')->with('success', 'Disfraz actualizado con imagen.');
    }


    // Eliminar disfraz
    public function destroy($id)
    {
        $disfraz = Disfraz::findOrFail($id);
        $disfraz->delete();

        return redirect()->route('admin.disfraces.index')->with('success', 'Disfraz eliminado con éxito.');
    }

}