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

    private function actualizarEstadosAlquileres()
    {
        $hoy = now()->startOfDay();

        Alquiler::where('estado', 'reservada')
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->update(['estado' => 'activa']);

        Alquiler::where('estado', 'activa')
            ->whereDate('fecha_fin', '<', $hoy)
            ->update(['estado' => 'retrasada']);
    }

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

        $alquileresRetrasados = Alquiler::where('usuario_id', $userId)
            ->where('estado', 'retrasada')
            ->count();

        $historial = Alquiler::where('usuario_id', $userId)
            ->whereIn('estado', ['finalizada', 'cancelada'])
            ->count();
        $reservados = Alquiler::where('usuario_id', $userId)->count();
        $proximosVencimientos = Alquiler::with('disfraz')
            ->where('usuario_id', $userId)
            ->where('estado', 'activa')
            ->whereDate('fecha_fin', '<=', now()->addDays(3)) // próximos 3 días
            ->get()
            ->map(function ($alquiler) {
                $fechaFin = Carbon::parse($alquiler->fecha_fin)->startOfDay();
                $hoy = now()->startOfDay();
                $alquiler->dias_restantes = $hoy->diffInDays($fechaFin, false); // Puede ser positivo, cero o negativo
                return $alquiler;

            });

        return view('cliente.dashboard', compact('alquileresActivos', 'alquileresRetrasados', 'reservados', 'historial', 'user', 'proximosVencimientos'));
    }

    public function actualizarPerfil(Request $request)
    {
        $cliente = Auth::user(); // Obtener el cliente autenticado

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo,' . $cliente->id,
            'telefono' => 'nullable|string|max:20',
            'clave' => 'nullable|string|min:6|confirmed',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ✅ Validar la contraseña actual si se quiere cambiar
        if ($request->filled('clave')) {
            if (!Hash::check($request->clave_actual, $cliente->clave)) {
                return back()->withErrors(['clave_actual' => 'La contraseña actual no es correcta.'])->withInput();
            }
            $cliente->clave = Hash::make($request->clave);
        }


        // ✅ Actualizar datos
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->correo = $request->correo;
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
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $disfraz = Disfraz::findOrFail($request->disfraz_id);
        $precio = $disfraz->precio;
        $cantidad = $request->cantidad;
        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->startOfDay();
        $dias = $fechaInicio->diffInDays($fechaFin) + 1;
        $monto_base = $dias * $precio * $cantidad;
        $hoy = Carbon::now()->startOfDay();
        if ($hoy->lt($fechaInicio)) {
            $estado = 'reservada';
        } elseif ($hoy->between($fechaInicio, $fechaFin)) {
            $estado = 'activa';
        } else {
            $estado = 'retrasada';
        }
        $dias_retraso = $hoy->gt($fechaFin->copy()->addDay()) ? $fechaFin->copy()->addDay()->diffInDays($hoy) : 0;
        $monto_sancion = $dias_retraso * 10;
        $monto_total = $monto_base + $monto_sancion;


        Alquiler::create([
            'usuario_id' => auth()->id(),
            'disfraz_id' => $disfraz->id,
            'cantidad' => $cantidad,
            'precio' => $precio,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $estado,
            'dias_retraso' => $dias_retraso,
            'monto_base' => $monto_base,
            'monto_sancion' => $monto_sancion,
            'monto_total' => $monto_total,

        ]);

        return redirect()->route('cliente.alquileres.index')->with('success', 'Alquiler realizado con éxito.');
    }


    public function misAlquileres()
    {
        $this->actualizarEstadosAlquileres();

        $alquileres = Alquiler::with('disfraz')
            ->where('usuario_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($alquiler) {
                // Si está retrasado, calculamos la sanción dinámica
                if ($alquiler->estado === 'retrasada') {
                    $fechaFin = \Carbon\Carbon::parse($alquiler->fecha_fin)->startOfDay(); // +1 día de gracia
                    $hoy = now()->startOfDay();
                    $diasRetraso = $hoy->gt($fechaFin) ? $fechaFin->diffInDays($hoy) : 0;
                    $sancion = $diasRetraso * 10;

                    $alquiler->dias_retraso = $diasRetraso;
                    $alquiler->monto_sancion = $sancion;
                    $alquiler->monto_total = $alquiler->monto_base + $sancion;
                } else {
                    // Si no está retrasado, no hay sanción
                    $alquiler->dias_retraso = 0;
                    $alquiler->monto_sancion = 0;
                    $alquiler->monto_total = $alquiler->monto_base;
                }

                return $alquiler;
            });

        return view('cliente.alquileres.index', compact('alquileres'));
    }

    public function perfil()
    {
        $user = Auth::user();

        $activos = Alquiler::where('usuario_id', $user->id)->where('estado', 'activa')->count();
        $retrasados = Alquiler::where('usuario_id', $user->id)->where('estado', 'retrasada')->count();
        $reservados = Alquiler::where('usuario_id', $user->id)->where('estado', 'reservada')->count();

        $proximosVencimientos = Alquiler::with('disfraz')
            ->where('usuario_id', $user->id)
            ->where('estado', 'activa')
            ->whereDate('fecha_fin', '<=', now()->addDays(3)) // próximos 3 días
            ->get()
            ->map(function ($alquiler) {
                $alquiler->dias_restantes = (int) now()->diffInDays($alquiler->fecha_fin, false);
                return $alquiler;
            });

        return view('cliente.perfil', compact('user', 'activos', 'retrasados', 'reservados', 'proximosVencimientos'));
    }


    public function agregarAlCarrito(Request $request)
    {
        $request->validate([
            'disfraz_id' => 'required|exists:disfraces,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $item = \App\Models\CarritoItem::firstOrNew([
            'usuario_id' => auth()->id(),
            'disfraz_id' => $request->disfraz_id,
        ]);

        $item->cantidad = ($item->exists ? $item->cantidad : 0) + $request->cantidad;
        $item->save();

        return redirect()->route('cliente.carrito.ver')->with('success', 'Disfraz agregado al carrito.');
    }

    public function verCarrito()
    {
        $items = \App\Models\CarritoItem::with('disfraz')
            ->where('usuario_id', auth()->id())
            ->get();

        return view('cliente.carrito', compact('items'));
    }

    public function eliminarDelCarrito($id)
    {
        $item = \App\Models\CarritoItem::where('usuario_id', auth()->id())->findOrFail($id);
        $item->delete();

        return back()->with('success', 'Disfraz eliminado del carrito.');
    }

    public function checkout()
    {
        $items = \App\Models\CarritoItem::with('disfraz')
            ->where('usuario_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cliente.catalogo')->with('error', 'Tu carrito está vacío.');
        }

        return view('cliente.carrito.checkout', compact('items'));
    }

    public function procesarCheckout(Request $request)
    {
        $items = \App\Models\CarritoItem::with('disfraz')
            ->where('usuario_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cliente.catalogo')->with('error', 'Tu carrito está vacío.');
        }

        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $dias = $fechaInicio->diffInDays($fechaFin);

        foreach ($items as $item) {
            $disfraz = $item->disfraz;
            $cantidad = $item->cantidad;
            $total = $disfraz->precio * $cantidad;

            Alquiler::create([
                'usuario_id' => auth()->id(),
                'disfraz_id' => $disfraz->id,
                'cantidad' => $item->cantidad,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'estado' => 'reservada',
                'total' => $total,
            ]);

            $disfraz->cantidad_disponible -= $item->cantidad;
            $disfraz->save();
        }

        \App\Models\CarritoItem::where('usuario_id', auth()->id())->delete();

        return redirect()->route('cliente.alquileres.index')->with('success', '¡Checkout completado exitosamente!');
    }

    public function vistaPago(Request $request)
    {
        return view('cliente.pago', [
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
    }

    public function procesarPago(Request $request)
    {
        // Validar campos de pago
        $request->validate([
            'metodo_pago' => 'required',
            'numero_tarjeta' => 'required',
            'nombre_tarjeta' => 'required',
            'expiracion' => 'required',
            'cvv' => 'required',
        ]);

        // Simulación de pago exitoso
        $usuarioId = Auth::id();
        $itemsCarrito = CarritoItem::where('usuario_id', $usuarioId)->get();
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        foreach ($itemsCarrito as $item) {
            $total = $item->disfraz->precio * $item->cantidad;

            Alquiler::create([
                'usuario_id' => $usuarioId,
                'disfraz_id' => $item->disfraz_id,
                'cantidad' => $item->cantidad,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'estado' => 'reservada',
                'total' => $total,
            ]);
        }

        CarritoItem::where('usuario_id', $usuarioId)->delete();

        return redirect()->route('cliente.alquileres')->with('success', 'Pago realizado y alquiler registrado con éxito.');
    }


}