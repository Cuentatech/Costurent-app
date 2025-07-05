{{-- resources/views/admin/clientes/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Gestión de Clientes')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Clientes</h1>

    {{-- Alertas --}}  
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            @if(session('claveTemporal'))
                <br>
                <strong>Clave temporal:</strong> {{ session('claveTemporal') }}
            @endif
        </div>
    @endif


    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('admin.clientes.index') }}" class="mb-3">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por ID, nombre o apellido"
                value="{{ request('search') }}"
                autocomplete="off"
            >
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-danger">Limpiar</a>
        </div>
    </form>

    {{-- Botón para mostrar/ocultar formulario --}}
    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formularioRegistro" aria-expanded="false" aria-controls="formularioRegistro">
        + Registrar Nuevo Cliente
    </button>

    {{-- Formulario de registro (oculto por defecto) --}}
    <div class="collapse mb-4" id="formularioRegistro">
        <div class="card card-body shadow">
            <form action="{{ route('admin.clientes.guardarCliente') }}" method="POST" novalidate>
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}" required>
                        @error('apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}" required>
                        @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Registrar</button>
            </form>
        </div>
    </div>

    {{-- Tabla de clientes --}}
    @if($clientes->isEmpty())
        <div class="alert alert-info">No hay clientes registrados aún.</div>
    @else
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th> {{-- Nueva columna para acciones --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $editarId = request()->query('editar');
                    @endphp

                    @foreach ($clientes as $cliente)
                        @if($editarId == $cliente->id)
                            {{-- Fila editable --}}
                            <form action="{{ route('admin.clientes.update', $cliente->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>
                                        <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="apellido" value="{{ old('apellido', $cliente->apellido) }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="email" name="correo" value="{{ old('correo', $cliente->correo) }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="form-control">
                                    </td>
                                    <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                        <a href="{{ route('admin.clientes.index') }}" class="btn btn-sm btn-secondary">Cancelar</a>
                                    </td>
                                </tr>
                            </form>
                        @else
                            {{-- Fila normal --}}
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->apellido }}</td>
                                <td>{{ $cliente->correo }}</td>
                                <td>{{ $cliente->telefono ?? 'No registrado' }}</td>
                                <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.clientes.index', ['editar' => $cliente->id]) }}" class="btn btn-sm btn-warning">Editar</a>

                                    <form action="{{ route('admin.clientes.destroy', $cliente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $clientes->withQueryString()->links() }}
        </div>
    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">Volver al Dashboard</a>
</div>
@endsection
