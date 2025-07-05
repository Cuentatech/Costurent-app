<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Usuario;

class ClienteController extends Controller
{
    // Listar clientes
    public function index(Request $request)
    {
        $search = $request->input('search');

        $clientes = Usuario::where('rol', 'cliente')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', $search)
                        ->orWhere('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.clientes.index', compact('clientes', 'search'));
    }

    // Formulario para crear cliente
    public function create()
    {
        return view('admin.clientes.create');
    }

    // Guardar nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'telefono' => 'nullable|string|max:20',
        ]);

        // Generar contraseña aleatoria
        $claveTemporal = Str::random(10);

        // Crear cliente
        Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'clave' => bcrypt($claveTemporal),
            'telefono' => $request->telefono,
            'rol' => 'cliente',
        ]);

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente creado exitosamente.')
            ->with('claveTemporal', $claveTemporal);
    }

    // Formulario para editar cliente
    public function edit($id)
    {
        $cliente = Usuario::where('rol', 'cliente')->findOrFail($id);
        return view('admin.clientes.edit', compact('cliente'));
    }

    // Actualizar cliente
    public function update(Request $request, $id)
    {
        $cliente = Usuario::where('rol', 'cliente')->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo,' . $cliente->id,
            'telefono' => 'nullable|string|max:20',
        ]);

        $cliente->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
        ]);

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente actualizado correctamente.');
    }

    // Eliminar cliente
    public function destroy($id)
    {
        $cliente = Usuario::where('rol', 'cliente')->findOrFail($id);
        $cliente->delete();

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente eliminado correctamente.');
    }
}
