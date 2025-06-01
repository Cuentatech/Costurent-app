<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alquiler;

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
            'clave' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'clave' => bcrypt($request->clave),
            'telefono' => $request->telefono,
            'rol' => 'cliente',
        ]);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function listarClientes()
    {
        $clientes = Usuario::where('rol', 'cliente')->get();
        return view('admin.clientes.index', compact('clientes'));
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



    public function cambiarEstadoAlquiler($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->estado = $alquiler->estado === 'pendiente' ? 'devuelto' : 'pendiente';
        $alquiler->save();

        return redirect()->back()->with('success', 'Estado del alquiler actualizado.');
    }

    public function aplicarSancion($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->sancionado = true;
        $alquiler->save();

        return redirect()->back()->with('success', 'Sanción aplicada correctamente.');
    }
}