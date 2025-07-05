<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Disfraz;
use App\Models\Categoria;
use App\Models\Usuario;

class DisfrazController extends Controller
{
    // Mostrar todos los disfraces con filtros
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
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'cantidad_total' => 'required|integer|min:0',
            'cantidad_disponible' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $datos = $request->only([
            'nombre', 'descripcion', 'categoria_id',
            'cantidad_total', 'cantidad_disponible', 'precio'
        ]);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('disfraces', 'public');
        }

        Disfraz::create($datos);

        return redirect()->route('admin.disfraces.index')->with('success', 'Disfraz creado correctamente.');
    }

    // Mostrar formulario de edición (opcional si editas en la misma tabla)
    public function edit($id)
    {
        $disfraz = Disfraz::findOrFail($id);
        $categorias = Categoria::all();
        $disfraces = Disfraz::with('categoria')->get();

        return view('admin.disfraces.index', compact('disfraz', 'disfraces', 'categorias'));
    }

    // Actualizar perfil del administrador
    public function actualizarPerfil(Request $request)
    {
        $admin = Usuario::findOrFail(Auth::id());

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo'   => 'required|email|unique:usuarios,correo,' . $admin->id,
            'telefono' => 'nullable|string|max:20',
            'clave'    => 'nullable|string|min:6|confirmed',
            'imagen'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin->fill($request->only(['nombre', 'apellido', 'correo', 'telefono']));

        if ($request->hasFile('imagen')) {
            if ($admin->imagen && $admin->imagen !== 'default-user.png') {
                Storage::disk('public')->delete('usuarios/' . $admin->imagen);
            }

            $archivo = $request->file('imagen');
            $nombreImagen = time() . '_' . $archivo->getClientOriginalName();
            $archivo->storeAs('public/usuarios', $nombreImagen);

            $admin->imagen = $nombreImagen;
        }

        if ($request->filled('clave')) {
            $admin->clave = Hash::make($request->clave);
        }

        $admin->save();

        return redirect()->route('admin.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
