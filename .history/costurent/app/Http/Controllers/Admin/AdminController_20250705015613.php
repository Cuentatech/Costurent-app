<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alquiler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // 🧭 Panel principal del admin
    public function dashboard()
    {
        $totalClientes        = Usuario::where('rol', 'cliente')->count();
        $alquileresActivos    = Alquiler::where('estado', 'activa')->count();
        $alquileresRetrasados = Alquiler::where('estado', 'retrasada')->count();

        $clientesRecientes = Usuario::where('rol', 'cliente')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($cliente) {
                return [
                    'tipo'    => 'cliente',
                    'mensaje' => "{$cliente->nombre} {$cliente->apellido} se registró en el sistema",
                    'fecha'   => $cliente->created_at,
                    'color'   => 'primary',
                    'icono'   => 'bi-person-plus',
                ];
            });

        $alquileresCompletados = Alquiler::with('disfraz', 'cliente')
            ->where('estado', 'completado')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($alquiler) {
                $nombreCliente = optional($alquiler->cliente)->nombre ?? 'Cliente';
                $nombreDisfraz = optional($alquiler->disfraz)->nombre ?? 'Disfraz';
                return [
                    'tipo'    => 'alquiler_completado',
                    'mensaje' => "Alquiler completado: {$nombreDisfraz} - Cliente: {$nombreCliente}",
                    'fecha'   => $alquiler->updated_at,
                    'color'   => 'success',
                    'icono'   => 'bi-check-circle',
                ];
            });

        $alquileresRetrasos = Alquiler::with('disfraz', 'cliente')
            ->where('estado', 'retrasada')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($alquiler) {
                $nombreCliente = optional($alquiler->cliente)->nombre ?? 'Cliente';
                $nombreDisfraz = optional($alquiler->disfraz)->nombre ?? 'Disfraz';
                return [
                    'tipo'    => 'alquiler_retrasado',
                    'mensaje' => "Alquiler retrasado: {$nombreDisfraz} - Cliente: {$nombreCliente}",
                    'fecha'   => $alquiler->updated_at,
                    'color'   => 'warning',
                    'icono'   => 'bi-exclamation-triangle',
                ];
            });

        $actividades = $clientesRecientes
            ->concat($alquileresCompletados)
            ->concat($alquileresRetrasos)
            ->sortByDesc('fecha')
            ->take(6);

        return view('admin.dashboard', compact(
            'totalClientes',
            'alquileresActivos',
            'alquileresRetrasados',
            'actividades'
        ));
    }

    // 👤 Mostrar perfil
    public function perfil()
    {
        $admin = u::find(Auth::id());
        return view('admin.perfil.show', compact('admin'));
    }

    // 🛠️ Actualizar perfil
    public function actualizarPerfil(Request $request)
{
    $admin = Auth::user();

    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'correo' => 'required|email|max:255|unique:admins,correo,' . $admin->id,
        'telefono' => 'nullable|string|max:20',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'clave' => 'nullable|string|min:6|confirmed',
        'clave_actual' => 'required',
    ]);

    // Verificar contraseña actual
    if (!Hash::check($request->clave_actual, $admin->clave)) {
        return back()->withErrors(['clave_actual' => 'La contraseña actual es incorrecta.'])->withInput();
    }

    // Actualizar imagen si se sube una nueva
    if ($request->hasFile('imagen')) {
        $ruta = $request->file('imagen')->store('perfiles', 'public');
        $admin->foto = $ruta;
    }

    // Actualizar datos personales
    $admin->nombre = $request->nombre;
    $admin->apellido = $request->apellido;
    $admin->correo = $request->correo;
    $admin->telefono = $request->telefono;

    // Cambiar clave si se proporciona nueva
    if ($request->filled('clave')) {
        $admin->clave = Hash::make($request->clave);
    }

    $admin->save();

    return redirect()->route('admin.perfil')->with('success', 'Perfil actualizado correctamente');
}


}
