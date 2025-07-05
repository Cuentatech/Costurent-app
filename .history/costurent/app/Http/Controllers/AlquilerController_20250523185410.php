<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alquiler;

class AlquilerController extends Controller
{
    // Listar todos los alquileres
    public function index()
    {
        $alquileres = Alquiler::with(['usuario', 'disfraz'])->get();
        return view('admin.alquileres.index', compact('alquileres'));
    }

    // Cambiar al siguiente estado del alquiler en el flujo definido
    public function cambiarEstado($id)
    {
        $alquiler = Alquiler::findOrFail($id);

        $estados = ['reservada', 'activa', 'retrasada', 'finalizada', 'cancelada'];

        // Obtener el índice actual del estado
        $indiceActual = array_search($alquiler->estado, $estados);

        // Cambiar al siguiente estado solo si no está en el último
        if ($indiceActual !== false && $indiceActual < count($estados) - 1) {
            $alquiler->estado = $estados[$indiceActual + 1];
            $alquiler->save();

            return redirect()->route('alquileres.index')->with('success', 'Estado del alquiler actualizado a: ' . $alquiler->estado);
        }

        return redirect()->route('alquileres.index')->with('info', 'El alquiler ya está en el estado final o estado inválido.');
    }

    // Aplicar sanción al alquiler
    public function aplicarSancion($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->sancionado = true;
        $alquiler->save();

        return redirect()->route('alquileres.index')->with('success', 'Sanción aplicada correctamente.');
    }
}
