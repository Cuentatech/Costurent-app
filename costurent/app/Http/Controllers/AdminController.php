<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alquiler;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function listarClientes()
    {
        $clientes = Usuario::where('rol', 'cliente')->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function listarAlquileres()
    {
        $alquileres = Alquiler::with('disfraz', 'cliente')->get();
        return view('admin.alquileres.index', compact('alquileres'));
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