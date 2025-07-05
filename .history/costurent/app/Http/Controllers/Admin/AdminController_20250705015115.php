<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alquiler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
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
        $admin = Auth::user();
        return view('admin.perfil.show', compact('admin'));
    }

    // 🛠️ Actualizar perfil
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

    // ✅ Si se intenta cambiar la contraseña, verificar clave actual
    if ($request->filled('clave')) {
        if (!Hash::check($request->clave_actual, $admin->clave)) {
            return back()->withErrors(['clave_actual' => 'La contraseña actual no es correcta.'])->withInput();
        }
        $admin->clave = Hash::make($request->clave);
    }

    $admin->nombre   = $request->nombre;
    $admin->apellido = $request->apellido;
    $admin->correo   = $request->correo;
    $admin->telefono = $request->telefono;

    // ✅ Imagen de perfil
    if ($request->hasFile('imagen')) {
        // Eliminar la anterior si no es la predeterminada
        if ($admin->imagen && $admin->imagen !== 'usuarios/default-user.png') {
            Storage::disk('public')->delete($admin->imagen);
        }

        $nombreArchivo = time() . '_' . $request->imagen->getClientOriginalName();
        $request->imagen->storeAs('public/usuarios', $nombreArchivo);
        $admin->imagen = 'usuarios/' . $nombreArchivo;
    }

    $admin->save();
    $request->file('imagen')->store('perfiles', 'public');


    return redirect()->route('admin.perfil')->with('success', 'Perfil actualizado correctamente.');
}



}
