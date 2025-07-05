<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alquiler;
use App\Models\Usuario;
use App\Models\Disfraz;
use Carbon\Carbon;

class AlquilerController extends Controller
{
    // Listar todos los alquileres
    public function index(Request $request)
    {
        $alquileres = Alquiler::with(['usuario', 'disfraz'])->orderBy('id', 'desc')->get();
        $usuarios = Usuario::where('rol', 'cliente')->get(); // Solo clientes
        $disfraces = Disfraz::all();

        return view('admin.alquileres.index', compact('alquileres', 'usuarios', 'disfraces'));
    }

    // Mostrar formulario (opcional)
    public function create()
    {
        $usuarios = Usuario::where('rol', 'cliente')->get();
        $disfraces = Disfraz::all();

        return view('admin.alquileres.create', compact('usuarios', 'disfraces'));
    }

    // Guardar nuevo alquiler
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id'   => 'required|exists:usuarios,id',
            'disfraz_id'   => 'required|exists:disfraces,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'total'        => 'required|numeric|min:0',
        ]);

        // Verificar disponibilidad del disfraz
        $disfraz = Disfraz::findOrFail($request->disfraz_id);
        if ($disfraz->cantidad_disponible < 1) {
            return back()->with('info', 'El disfraz no está disponible.');
        }

        // Crear alquiler
        Alquiler::create([
            'usuario_id'   => $request->usuario_id,
            'disfraz_id'   => $request->disfraz_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'total'        => $request->total,
            'estado'       => 'reservada',
        ]);

        // Restar cantidad disponible
        $disfraz->decrement('cantidad_disponible');

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler registrado correctamente.');
    }

    // Actualizar estado del alquiler
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

    // Eliminar alquiler y restaurar disponibilidad del disfraz
    public function destroy($id)
    {
        $alquiler = Alquiler::findOrFail($id);

        // Restaurar cantidad disponible del disfraz
        $alquiler->disfraz->increment('cantidad_disponible');

        $alquiler->delete();

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler eliminado correctamente.');
    }

    // Aplicar sanción manual (opcional)
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
