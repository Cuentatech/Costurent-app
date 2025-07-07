<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disfraz;
use Carbon\Carbon;
use App\Models\Alquiler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


use App\Models\Categoria;

class ClienteController extends Controller
{

    
    public function catalogo(Request $request)
    {
        $categorias = Categoria::all();

        $disfracesAgrupados = Disfraz::with('categoria')
            ->when($request->busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'like', "%$busqueda%");
            })
            ->when($request->categoria, function ($query, $categoria) {
                $query->where('categoria_id', $categoria);
            })
            ->get()
            ->groupBy(fn($d) => $d->categoria->nombre ?? 'Sin categoría');

        return view('cliente.catalogo', compact('categorias', 'disfracesAgrupados'));
    }


    public function dashboard()
    {
        $user = auth()->user();
        $userId = $user->id;
        $alquileresActivos = Alquiler::where('usuario_id', $userId)
            ->where('estado', 'activa')
            ->count();

        $historial = Alquiler::where('usuario_id', $userId)
            ->whereIn('estado', ['finalizada', 'cancelada'])
            ->count();

        return view('cliente.dashboard', compact('alquileresActivos', 'historial','user'));
    }

    public function actualizarPerfil(Request $request)
    {
        $cliente = Auth::user(); // Obtener el cliente autenticado

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo'   => 'required|email|unique:usuarios,correo,' . $cliente->id,
            'telefono' => 'nullable|string|max:20',
            'clave'    => 'nullable|string|min:6|confirmed',
            'imagen'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ✅ Validar la contraseña actual si se quiere cambiar
        if ($request->filled('clave')) {
            if (!Hash::check($request->clave_actual, $cliente->clave)) {
                return back()->withErrors(['clave_actual' => 'La contraseña actual no es correcta.'])->withInput();
            }
            $cliente->clave = Hash::make($request->clave);
        }

        // ✅ Actualizar datos
        $cliente->nombre   = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->correo   = $request->correo;
        $cliente->telefono = $request->telefono;

        // ✅ Actualizar imagen si se sube una nueva
        if ($request->hasFile('imagen')) {
            if ($cliente->imagen && $cliente->imagen !== 'usuarios/default-user.png') {
                Storage::disk('public')->delete($cliente->imagen);
            }

            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $ruta = $request->file('imagen')->storeAs('usuarios', $nombreArchivo, 'public');
            $cliente->imagen = $ruta;
        }

        $cliente->save();

        return redirect()->route('cliente.dashboard')->with('success', 'Perfil actualizado correctamente.');
    }

    public function formAlquiler(Disfraz $disfraz)
    {
        return view('cliente.alquileres.crear', compact('disfraz'));
    }

    public function guardarAlquiler(Request $request)
    {
        $request->validate([
            'disfraz_id' => 'required|exists:disfraces,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $dias = Carbon::parse($request->fecha_inicio)->diffInDays(Carbon::parse($request->fecha_fin));
        $disfraz = Disfraz::findOrFail($request->disfraz_id);
        $total = $dias * $disfraz->precio * $request->cantidad;

        Alquiler::create([
            'usuario_id' => auth()->id(),
            'disfraz_id' => $disfraz->id,
            'cantidad' => $request->cantidad,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'total' => $total,
            'estado' => 'reservada',
        ]);

        return redirect()->route('cliente.alquileres.index')->with('success', 'Alquiler realizado con éxito.');
    }

    public function misAlquileres()
    {
        $alquileres = Alquiler::with('disfraz')
            ->where('usuario_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($alquiler) {
                if ($alquiler->estado === 'retrasada') {
                    $fechaFin = \Carbon\Carbon::parse($alquiler->fecha_fin)->startOfDay();
                    $hoy = now()->startOfDay();
                    $diasRetraso = $fechaFin->diffInDays($hoy, false);
                    $diasRetraso = $diasRetraso > 0 ? $diasRetraso : 0;
                    $sancion = $diasRetraso * 10;

                    $alquiler->dias_retraso = $diasRetraso;
                    $alquiler->monto_sancion = $sancion;
                    $alquiler->monto_total = $alquiler->total + $sancion;
                } else {
                    $alquiler->monto_total = $alquiler->total;
                }
                return $alquiler;
            });

        return view('cliente.alquileres.index', compact('alquileres'));
    }



}
