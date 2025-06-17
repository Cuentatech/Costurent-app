<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'clave' => 'required|string',
            'rol' => 'required|in:cliente,administrador',
        ]);

        $usuario = Usuario::where('correo', $request->correo)
            ->where('rol', $request->rol)
            ->first();

        if (!$usuario || !Hash::check($request->clave, $usuario->clave)) {
            return back()->withErrors([
                'correo' => 'Credenciales incorrectas o rol no válido.',
            ])->withInput();
        }

        Auth::login($usuario);

        // Redirección según el rol
        return match ($usuario->rol) {
            'administrador' => redirect()->route('admin.dashboard'),
            'cliente'       => redirect()->route('cliente.dashboard'),
            default         => redirect()->route('login')->withErrors(['rol' => 'Rol no autorizado.']),
        };
    }

    // Mostrar formulario de registro (solo clientes)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar registro (solo clientes)
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'clave' => 'required|string|min:6|confirmed',
            'telefono' => 'nullable|string|max:20',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'clave' => Hash::make($request->clave),
            'telefono' => $request->telefono,
            'rol' => 'cliente',  // registro solo para clientes
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada con éxito, ya puedes iniciar sesión.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
