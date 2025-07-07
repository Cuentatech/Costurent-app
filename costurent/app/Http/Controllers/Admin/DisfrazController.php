<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Disfraz;
use App\Models\Categoria;
use App\Models\Usuario;
use App\Http\Controllers\Controller;

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

        public function destroy($id)
    {
        $disfraz = Disfraz::findOrFail($id);

        // Elimina imagen si existe
        if ($disfraz->imagen) {
            Storage::disk('public')->delete($disfraz->imagen);
        }

        $disfraz->delete();

        return redirect()->route('admin.disfraces.index')->with('success', 'Disfraz eliminado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $disfraz = Disfraz::findOrFail($id);
        $disfraces = Disfraz::with('categoria')->get();
        $categorias = \App\Models\Categoria::all();

        return view('admin.disfraces.index', compact('disfraz', 'disfraces', 'categorias'));
    }

        public function actualizarPerfil(Request $request)
    {
        $admin = Usuario::find(Auth::id());

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo'   => 'required|email|unique:usuarios,correo,' . $admin->id,
            'telefono' => 'nullable|string|max:20',
            'clave'    => 'nullable|string|min:6|confirmed',
            'imagen'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin->nombre   = $request->nombre;
        $admin->apellido = $request->apellido;
        $admin->correo   = $request->correo;
        $admin->telefono = $request->telefono;

        // ✅ Manejar la imagen si fue subida
        if ($request->hasFile('imagen')) {
            // Borrar la imagen anterior si no es la por defecto
            if ($admin->imagen && $admin->imagen !== 'default-user.png') {
                Storage::disk('public')->delete('usuarios/' . $admin->imagen);
            }

            // Subir la nueva imagen
            $archivo = $request->file('imagen');
            $nombreImagen = time() . '_' . $archivo->getClientOriginalName();
            $archivo->storeAs('public/usuarios', $nombreImagen);

            // Guardar en BD
            $admin->imagen = $nombreImagen;
        }

        // ✅ Cambiar contraseña solo si se proporcionó
        if ($request->filled('clave')) {
            $admin->clave = Hash::make($request->clave);
        }

        $admin->save();

        return redirect()->route('admin.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
    public function update(Request $request, $id)
{
    $disfraz = Disfraz::findOrFail($id);

    $request->validate([
        'nombre' => 'required',
        'descripcion' => 'nullable',
        'categoria_id' => 'required|exists:categorias,id',
        'cantidad_total' => 'required|integer',
        'cantidad_disponible' => 'required|integer',
        'precio' => 'required|numeric',
        'imagen' => 'nullable|image|max:2048',
    ]);

    $datos = $request->only([
        'nombre',
        'descripcion',
        'categoria_id',
        'cantidad_total',
        'cantidad_disponible',
        'precio'
    ]);

    if ($request->hasFile('imagen')) {
        // Borra la imagen anterior si existe
        if ($disfraz->imagen) {
            Storage::disk('public')->delete($disfraz->imagen);
        }

        $datos['imagen'] = $request->file('imagen')->store('disfraces', 'public');
    }

    $disfraz->update($datos);

    return redirect()->route('admin.disfraces.index')->with('success', 'Disfraz actualizado correctamente.');
}


}