@extends('layouts.cliente')

@section('title', 'Mis Alquileres')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">🎭 Mis Alquileres</h2>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($alquileres->count())
        <div class="table-responsive shadow-sm rounded bg-white">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Disfraz</th>
                        <th>Cantidad</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th class="text-end">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alquileres as $alquiler)
                        @php
                            $montoBase = $alquiler->total;
                            $sancion = $alquiler->monto_sancion ?? 0;
                            $montoFinal = $montoBase + $sancion;
                            $fechaInicio = \Carbon\Carbon::parse($alquiler->fecha_inicio)->format('d/m/Y');
                            $fechaFin = \Carbon\Carbon::parse($alquiler->fecha_fin)->format('d/m/Y');
                        @endphp
                        <tr>
                            <td>{{ $alquiler->disfraz->nombre }}</td>
                            <td>{{ $alquiler->cantidad }}</td>
                            <td>{{ $fechaInicio }}</td>
                            <td>{{ $fechaFin }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $alquiler->estado === 'activa' ? 'success' :
                                    ($alquiler->estado === 'retrasada' ? 'warning text-dark' :
                                    ($alquiler->estado === 'reservada' ? 'info' :
                                    ($alquiler->estado === 'cancelada' ? 'danger' : 'secondary'))) 
                                }}">
                                    {{ ucfirst($alquiler->estado) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div>S/ {{ number_format($montoBase, 2) }}</div>
                                @if($alquiler->estado === 'retrasada' && $sancion > 0)
                                    <small class="text-danger">+ Sanción: S/ {{ number_format($sancion, 2) }}</small><br>
                                    <strong class="text-primary">Total: S/ {{ number_format($montoFinal, 2) }}</strong>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info mt-4">
            <i class="bi bi-info-circle-fill me-2"></i> Aún no tienes alquileres registrados.
        </div>
    @endif
</div>
@endsection
