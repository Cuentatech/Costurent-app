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
    public function index(Request $request)
{
    $disfraces = Disfraz::all();
    $usuarios = Usuario::where('rol', 'cliente')->get();

    $query = Alquiler::with(['usuario', 'disfraz']);

    // FILTRO POR NOMBRE DE CLIENTE (MANUAL)
    if ($request->filled('search')) {
        $query->whereHas('usuario', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->search . '%');
        });
    }

    $alquileres = $query->get();

    return view('admin.alquileres.index', compact('alquileres', 'usuarios', 'disfraces'));
}


   public function store(Request $request)
{
    $request->validate([
        'usuario_id'     => 'required|exists:usuarios,id',
        'disfraz_id'     => 'required|exists:disfraces,id',
        'fecha_inicio'   => 'required|date',
        'fecha_fin'      => 'required|date|after_or_equal:fecha_inicio',
        'cantidad'       => 'required|integer|min:1',
    ]);

    $disfraz = Disfraz::findOrFail($request->disfraz_id);

    // Verificar disponibilidad
    if ($disfraz->cantidad_disponible < $request->cantidad) {
        return back()->with('info', 'No hay suficiente cantidad disponible.');
    }

    $precio = $disfraz->precio;
    $cantidad = $request->cantidad;
    $monto_base = $precio * $cantidad;

    // Calcular estado
    $hoy = Carbon::now()->startOfDay();
    $inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
    $fin = Carbon::parse($request->fecha_fin)->startOfDay();

    if ($hoy->lt($inicio)) {
        $estado = 'reservada';
    } elseif ($hoy->between($inicio, $fin)) {
        $estado = 'activa';
    } else {
        $estado = 'retrasada';
    }

    // Calcular sanción
    $dias_retraso = $hoy->gt($fin->copy()->addDay()) ? $fin->copy()->addDay()->diffInDays($hoy) : 0;
    $monto_sancion = $dias_retraso * 10;
    $monto_total = $monto_base + $monto_sancion;

    // Guardar alquiler
    Alquiler::create([
        'usuario_id'     => $request->usuario_id,
        'disfraz_id'     => $request->disfraz_id,
        'cantidad'       => $cantidad,
        'precio'         => $precio,
        'fecha_inicio'   => $request->fecha_inicio,
        'fecha_fin'      => $request->fecha_fin,
        'estado'         => $estado,
        'dias_retraso'   => $dias_retraso,
        'monto_sancion'  => $monto_sancion,
        'monto_total'    => $monto_total,
    ]);

    // Restar del stock
    $disfraz->cantidad_disponible -= $cantidad;
    $disfraz->save();

    return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler registrado correctamente.');
}


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

    public function destroy($id)
    {
        $alquiler = Alquiler::findOrFail($id);

        // Devolver cantidad al stock
        $alquiler->disfraz->cantidad_disponible += $alquiler->cantidad;
        $alquiler->disfraz->save();

        $alquiler->delete();

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler eliminado correctamente.');
    }
}
