<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Panel principal del admin
    public function dashboard()
    {
        $totalClientes        = Usuario::where('rol', 'cliente')->count();
        $alquileresActivos    = \App\Models\Alquiler::where('estado', 'activa')->count();
        $alquileresRetrasados = \App\Models\Alquiler::where('estado', 'retrasada')->count();

        return view('admin.dashboard', compact(
            'totalClientes',
            'alquileresActivos',
            'alquileresRetrasados'
        ));
    }

    // 👤 Ver perfil del administrador autenticado
    public function perfil()
    {
        $admin = Auth::user(); // El usuario logueado
        return view('admin.perfil.show', compact('admin'));
    }

    // 🛠️ Editar perfil del administrador
    public function actualizarPerfil(Request $request)
    {
        $admin = Usuario::find(Auth::id());

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo'   => 'required|email|unique:usuarios,correo,' . $admin->id,
            'telefono' => 'nullable|string|max:20',
            'clave'    => 'nullable|string|min:6|confirmed', // Si desea cambiarla
        ]);

        $admin->nombre   = $request->nombre;
        $admin->apellido = $request->apellido;
        $admin->correo   = $request->correo;
        $admin->telefono = $request->telefono;

        if ($request->filled('clave')) {
            $admin->clave = Hash::make($request->clave);
        }

        $admin->save();

        return redirect()->route('admin.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
