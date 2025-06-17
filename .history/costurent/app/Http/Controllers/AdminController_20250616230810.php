<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alquiler;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClientes = Usuario::where('rol', 'cliente')->count();
        $alquileresActivos = Alquiler::where('estado', 'activa')->count();
        $alquileresRetrasados = Alquiler::where('estado', 'retrasada')->count();

        return view('admin.dashboard', compact('totalClientes', 'alquileresActivos', 'alquileresRetrasados'));
    }

    public function createCliente()
    {
        return view('admin.clientes.create');
    }

    public function guardarCliente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'telefono' => 'nullable|string|max:20',
        ]);

        // Generar contraseña aleatoria
        $claveTemporal = Str::random(10);

        // Crear el usuario con contraseña encriptada
        Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'clave' => bcrypt($claveTemporal),
            'telefono' => $request->telefono,
            'rol' => 'cliente',
        ]);

        // Guardar clave temporal en sesión para mostrar después
        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente creado exitosamente.')
            ->with('claveTemporal', $claveTemporal);
    }

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

    // Mostrar formulario para editar cliente - LINEA
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

        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->correo = $request->correo;
        $cliente->telefono = $request->telefono;
        $cliente->save();

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
    public function listarAlquileres(Request $request)
    {
        $search = $request->input('search');

        $query = Alquiler::with(['usuario', 'disfraz']);

        if ($search) {
            $query->whereHas('usuario', function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $alquileres = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.alquileres.index', compact('alquileres', 'search'));
    }
    
    public function eliminarAlquiler($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->delete();

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler eliminado correctamente.');
    }
    public function updatealquiler(Request $request, $id)
    {
        $alquiler = Alquiler::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:reservada,activa,retrasada,finalizada,cancelada',
            'monto_sancion' => 'nullable|numeric|min:0',
        ]);

        $alquiler->estado = $request->estado;
        $alquiler->monto_sancion = $request->monto_sancion;
        $alquiler->save();

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler actualizado correctamente.');
    }
    public function cambiarEstadoAlquiler(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:reservada,activa,retrasada,finalizada,cancelada',
        ]);

        $alquiler = Alquiler::findOrFail($id);
        $alquiler->estado = $request->estado;
        $alquiler->save();

        return redirect()->route('admin.alquileres.index')->with('success', 'Estado actualizado.');
    }

    public function aplicarSancion(Request $request, $id)
    {
        $request->validate([
            'sancion' => 'nullable|string|max:255',
        ]);

        $alquiler = Alquiler::findOrFail($id);
        $alquiler->sancion = $request->sancion;
        $alquiler->save();

        return redirect()->route('admin.alquileres.index')->with('success', 'Sanción aplicada.');
        }
        
}