<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Disfraz;

class ClienteController extends Controller
{
    // Panel del cliente
    public function dashboard()
    {
        return view('cliente.dashboard');
    }

    // Ver perfil
    public function perfil()
    {
        $cliente = Auth::user();
        return view('cliente.perfil', compact('cliente'));
    }

    // Editar perfil (formulario)
    public function editarPerfil()
    {
        $cliente = Auth::cliente();
        return view('cliente.editar', compact('cliente'));
    }

    public function actualizarPerfil(Request $request)
    {
        $cliente = Auth::cliente();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'clave' => 'nullable|string|min:6|confirmed'
        ]);

        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->telefono = $request->telefono;

        if ($request->filled('clave')) {
            $cliente->clave = Hash::make($request->clave);
        }
        $cliente->save();

        return redirect()->route('cliente.perfil')->with('success', 'Perfil actualizadO');
    }

    public function verDisfraces()
    {
        $disfraces = Disfraz::where('cantidad_disponible', '>', 0)->get();
        return view('cliente.disfraces', compact('disfraces'));
    }
}
