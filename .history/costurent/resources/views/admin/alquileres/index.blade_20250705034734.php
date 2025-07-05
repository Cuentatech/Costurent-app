@extends('layouts.admin')

@section('title', 'Gestión de Alquileres')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Alquileres</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    {{-- Búsqueda manual por nombre del cliente --}}
    <form method="GET" action="{{ route('admin.alquileres.index') }}" class="mb-3">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por nombre del cliente"
                value="{{ request('search') }}"
            >
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
            <a href="{{ route('admin.alquileres.index') }}" class="btn btn-outline-danger">Limpiar</a>
        </div>
    </form>

    {{-- Botón para desplegar formulario --}}
    <button class="btn btn-success mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#nuevoAlquiler">+ Nuevo Alquiler</button>

    <div id="nuevoAlquiler" class="collapse mb-4">
        <div class="card p-4 shadow-sm">
            <form action="{{ route('admin.alquileres.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cliente</label>
                        <select name="usuario_id" class="form-select" required>
                            <option value="">Seleccione</option>
                            @foreach($usuarios as $u)
                                <option value="{{ $u->id }}">{{ $u->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Disfraz</label>
                        <select name="disfraz_id" class="form-select" required>
                            <option value="">Seleccione</option>
                            @foreach($disfraces as $d)
                                <option value="{{ $d->id }}">{{ $d->nombre }} (S/.{{ $d->precio }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary">Registrar Alquiler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($alquileres->isEmpty())
        <div class="alert alert-info">No hay alquileres registrados.</div>
    @else
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Disfraz</th>
                        <th>Cant.</th>
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
                    @foreach($alquileres as $a)
                        @php
                            $hoy = \Carbon\Carbon::now()->startOfDay();
                            $fin = \Carbon\Carbon::parse($a->fecha_fin)->startOfDay()->addDay();
                            $diasRetraso = $hoy->gt($fin) && $a->estado !== 'finalizada' ? $fin->diffInDays($hoy) : 0;
                            $sancion = $diasRetraso * 10;
                            $montoFinal = $a->total + $sancion;
                        @endphp

                        @if(request('edit') == $a->id)
                            <form action="{{ route('admin.alquileres.update', $a->id) }}" method="POST">
                                @csrf @method('PUT')
                                <tr>
                                    <td>{{ $a->id }}</td>
                                    <td>{{ $a->usuario->nombre }}</td>
                                    <td>{{ $a->disfraz->nombre }}</td>
                                    <td><input name="cantidad" class="form-control form-control-sm" type="number" value="{{ $a->cantidad }}"></td>
                                    <td><input name="fecha_inicio" class="form-control form-control-sm" type="date" value="{{ $a->fecha_inicio }}"></td>
                                    <td><input name="fecha_fin" class="form-control form-control-sm" type="date" value="{{ $a->fecha_fin }}"></td>
                                    <td>S/. {{ number_format($a->total, 2) }}</td>
                                    <td>
                                        <select name="estado" class="form-select form-select-sm">
                                            @foreach(['reservada','activa','retrasada','finalizada','cancelada'] as $estado)
                                                <option value="{{ $estado }}" {{ $a->estado == $estado ? 'selected' : '' }}>{{ ucfirst($estado) }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $diasRetraso ? $diasRetraso . ' día(s)' : '-' }}</td>
                                    <td>{{ $sancion ? 'S/. ' . number_format($sancion, 2) : '-' }}</td>
                                    <td>S/. {{ number_format($montoFinal, 2) }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm">Guardar</button>
                                        <a href="{{ route('admin.alquileres.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                                    </td>
                                </tr>
                            </form>
                        @else
                            <tr>
                                <td>{{ $a->id }}</td>
                                <td>{{ $a->usuario->nombre }}</td>
                                <td>{{ $a->disfraz->nombre }}</td>
                                <td>{{ $a->cantidad }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->fecha_fin)->format('d/m/Y') }}</td>
                                <td>S/. {{ number_format($a->total, 2) }}</td>
                                <td>{{ ucfirst($a->estado) }}</td>
                                <td>{{ $diasRetraso ? $diasRetraso . ' día(s)' : '-' }}</td>
                                <td>{{ $sancion ? 'S/. ' . number_format($sancion, 2) : '-' }}</td>
                                <td>S/. {{ number_format($montoFinal, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.alquileres.index', ['edit' => $a->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form method="POST" action="{{ route('admin.alquileres.destroy', $a->id) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este alquiler?')">
                                        @csrf @method('DELETE')
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

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">Volver</a>
</div>
@endsection
