+<?php

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
        $alquileres = Alquiler::with(['usuario', 'disfraz'])->orderBy('id', 'desc')->get();
        $usuarios = Usuario::where('rol', 'cliente')->get(); // Solo clientes
        $disfraces = Disfraz::all();

        return view('admin.alquileres.index', compact('alquileres', 'usuarios', 'disfraces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id'      => 'required|exists:usuarios,id',
            'disfraz_id'      => 'required|exists:disfraces,id',
            'fecha_inicio'    => 'required|date',
            'fecha_fin'       => 'required|date|after_or_equal:fecha_inicio',
            'total'           => 'required|numeric|min:0',
        ]);

        Alquiler::create([
            'usuario_id'   => $request->usuario_id,
            'disfraz_id'   => $request->disfraz_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'total'        => $request->total,
            'estado'       => 'reservada',
        ]);

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $alquiler = Alquiler::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:reservada,activa,retrasada,finalizada,cancelada'
        ]);

        $alquiler->estado = $request->estado;
        $alquiler->save();

        return redirect()->route('admin.alquileres.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $alquiler = Alquiler::findOrFail($id);
        $alquiler->delete();

        return redirect()->route('admin.alquileres.index')->with('success', 'Alquiler eliminado correctamente.');
    }
}
