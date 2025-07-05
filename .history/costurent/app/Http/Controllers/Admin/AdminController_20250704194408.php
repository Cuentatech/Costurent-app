<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Alquiler;

class AdminController extends Controller
{
    /**
     * Muestra el panel principal del administrador con estadísticas clave.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $totalClientes         = Usuario::where('rol', 'cliente')->count();
        $alquileresActivos     = Alquiler::where('estado', 'activa')->count();
        $alquileresRetrasados  = Alquiler::where('estado', 'retrasada')->count();

        return view('admin.dashboard', compact(
            'totalClientes',
            'alquileresActivos',
            'alquileresRetrasados'
        ));
    }
}
