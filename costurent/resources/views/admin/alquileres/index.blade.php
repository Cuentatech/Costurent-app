{{-- resources/views/admin/alquileres/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Gestión de Alquileres')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Alquileres</h1>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('admin.alquileres.index') }}" class="mb-3">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por cliente"
                value="{{ request('search') }}"
                autocomplete="off"
            >
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            <a href="{{ route('admin.alquileres.index') }}" class="btn btn-outline-danger">Limpiar</a>
        </div>
    </form>

    {{-- Tabla de alquileres --}}
    @if($alquileres->isEmpty())
        <div class="alert alert-info">No hay alquileres registrados aún.</div>
    @else
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Disfraz</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Retraso</th>
                        <th>Sanción</th>
                        <th>Monto Final</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alquileres as $alquiler)
                        @php
                            $editId = request('edit');
                            $fechaFin = \Carbon\Carbon::parse($alquiler->fecha_fin)->startOfDay()->addDay();
                            $hoy = \Carbon\Carbon::now()->startOfDay();
                            $diasRetraso = 0;
                            if ($hoy->gt($fechaFin) && $alquiler->estado !== 'finalizada') {
                                $diasRetraso = $fechaFin->diffInDays($hoy);
                            }
                            $montoSancion = $diasRetraso * 10;
                            $montoFinal = $alquiler->total + $montoSancion;
                        @endphp

                        @if($editId == $alquiler->id)
                            <form action="{{ route('admin.alquileres.update', $alquiler->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <tr>
                                    <td>{{ $alquiler->id }}</td>
                                    <td>{{ $alquiler->usuario->nombre }}</td>
                                    <td>{{ $alquiler->disfraz->nombre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($alquiler->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($alquiler->fecha_fin)->format('d/m/Y') }}</td>
                                    <td>S/ {{ number_format($alquiler->total, 2) }}</td>
                                    <td>
                                        <select name="estado" class="form-select form-select-sm">
                                            @foreach(['reservada','activa','retrasada','finalizada','cancelada'] as $estado)
                                                <option value="{{ $estado }}" {{ $alquiler->estado === $estado ? 'selected' : '' }}>
                                                    {{ ucfirst($estado) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $diasRetraso > 0 ? $diasRetraso . ' día(s)' : '-' }}</td>
                                    <td>
                                        {{ $diasRetraso > 0 ? 'S/ ' . number_format($diasRetraso * 10, 2) : '-' }}
                                    </td>
                                    <td>S/ {{ number_format($montoFinal, 2) }}</td> {{-- Monto Final --}}
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                        <a href="{{ route('admin.alquileres.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                                    </td>
                                </tr>
                            </form>
                        @else
                            <tr>
                                <td>{{ $alquiler->id }}</td>
                                <td>{{ $alquiler->usuario->nombre }}</td>
                                <td>{{ $alquiler->disfraz->nombre }}</td>
                                <td>{{ \Carbon\Carbon::parse($alquiler->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($alquiler->fecha_fin)->format('d/m/Y') }}</td>
                                <td>S/ {{ number_format($alquiler->total, 2) }}</td>
                                <td>{{ ucfirst($alquiler->estado) }}</td>
                                <td>{{ $diasRetraso > 0 ? $diasRetraso . ' día(s)' : '-' }}</td>
                                <td>{{ $diasRetraso > 0 ? 'S/ ' . number_format($diasRetraso * 10, 2) : '-' }}</td>
                                <td>S/ {{ number_format($montoFinal, 2) }}</td> {{-- Monto Final --}}
                                
                                <td>
                                    <a href="{{ route('admin.alquileres.index', ['edit' => $alquiler->id]) }}" class="btn btn-warning btn-sm">Editar</a>

                                    <form method="POST" action="{{ route('admin.alquileres.destroy', $alquiler->id) }}" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este alquiler?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">Volver al Dashboard</a>
</div>
@endsection