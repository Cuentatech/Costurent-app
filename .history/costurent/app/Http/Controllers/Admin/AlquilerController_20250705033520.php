<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alquiler;
use App\Models\Usuario;
use App\Models\Disfraz;

class AlquilerController extends Controller
{
    // Listar todos los alquileres
    public function index(Request $request)
    {
        $alquileres = Alquiler::with(['usuario', 'disfraz'])->get();
        $usuarios = Usuario::all();
        $disfraces = Disfraz::all();

        return view('admin.alquileres.index', compact('alquileres', 'usuarios', 'disfraces'));
    }

    // Mostrar formulario de creación (opcional si usas modal)
    public function create()
    {
        $usuarios = Usuario::all();
        $disfraces = Disfraz::all();

        return view('admin.alquileres.create', compact('usuarios', 'disfraces'));
    }

    // Guardar nuevo alquiler
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id'     => 'required|exists:usuarios,id',
            'disfraz_id'     => 'required|exists:disfraces,id',
            'fecha_inicio'   => 'required|date',
            'fecha_fin'      => 'required|date|after_or_equal:fecha_inicio',
            'total'          => 'required|numeric|min:0',
            'estado'         => 'required|in:reservada,activa,retrasada,finalizada,cancelada',
        ]);

        Alquiler::create($request->all());

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler registrado correctamente.');
    }

    // Editar alquiler (solo estado)
    public function update(Request $request, $id)
    {
        $alquiler = Alquiler::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:reservada,activa,retrasada,finalizada,cancelada',
        ]);

        $alquiler->estado = $request->estado;
        $alquiler->save();

        return redirect()->route('admin.alquileres.index')->with('success', 'Estado actualizado correctamente.');
    }

    // Eliminar alquiler
    public function destroy($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->delete();

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler eliminado correctamente.');
    }

    // Aplicar sanción manualmente (opcional)
    public function aplicarSancion($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->sancionado = true;
        $alquiler->save();

        return redirect()->route('admin.alquileres.index')->with('success', 'Sanción aplicada correctamente.');
    }

    // Cambiar automáticamente al siguiente estado
    public function cambiarEstado($id)
    {
        $alquiler = Alquiler::findOrFail($id);

        $estados = ['reservada', 'activa', 'retrasada', 'finalizada', 'cancelada'];
        $indiceActual = array_search($alquiler->estado, $estados);

        if ($indiceActual !== false && $indiceActual < count($estados) - 1) {
            $alquiler->estado = $estados[$indiceActual + 1];
            $alquiler->save();

            return redirect()->route('admin.alquileres.index')->with('success', 'Estado actualizado a: ' . $alquiler->estado);
        }

        return redirect()->route('admin.alquileres.index')->with('info', 'Ya está en el estado final.');
    }
}
