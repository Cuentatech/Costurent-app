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
    



}
