@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Disfraces</h1>

    {{-- Buscador y Filtro por Categoría --}}
    <form method="GET" action="{{ route('admin.disfraces.index') }}" class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o descripción" value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="categoria" class="form-select" onchange="this.form.submit()">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">Buscar</button>
        </div>
    </form>

    {{-- Botones para mostrar formularios --}}
    <div class="d-flex gap-2 mb-4">
        <button class="btn btn-success" onclick="mostrarFormulario('disfraz')">+ Añadir Disfraz</button>
        <button class="btn btn-primary" onclick="mostrarFormulario('categoria')">+ Añadir Categoría</button>
    </div>

    {{-- Formulario Disfraz --}}
    <div id="formulario-disfraz" class="card p-4 mb-4 shadow d-none">
        <form method="POST" action="{{ route('admin.disfraces.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Cantidad Total</label>
                    <input type="number" name="cantidad_total" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cantidad Disponible</label>
                    <input type="number" name="cantidad_disponible" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    {{-- Formulario Categoría --}}
    <div id="formulario-categoria" class="card p-4 mb-4 shadow d-none">
        <form method="POST" action="{{ route('admin.categorias.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nombre de Categoría</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Categoría</button>
        </form>
    </div>

    

    {{-- Tabla de disfraces --}}
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Total</th>
                    <th>Disponible</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $editarId = request('editar');
                @endphp

                @foreach ($disfraces as $d)
                    @if ($editarId == $d->id)
                        <form action="{{ route('admin.disfraces.update', $d->id) }}" method="POST">
                            @csrf @method('PUT')
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td><input type="text" name="nombre" value="{{ $d->nombre }}" class="form-control" required></td>
                                <td>
                                    <select name="categoria_id" class="form-select">
                                        @foreach ($categorias as $cat)
                                            <option value="{{ $cat->id }}" {{ $cat->id == $d->categoria_id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="cantidad_total" value="{{ $d->cantidad_total }}" class="form-control" required></td>
                                <td><input type="number" name="cantidad_disponible" value="{{ $d->cantidad_disponible }}" class="form-control" required></td>
                                <td><input type="number" name="precio" value="{{ $d->precio }}" step="0.01" class="form-control" required></td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-sm btn-secondary">Cancelar</a>
                                </td>
                            </tr>
                        </form>
                    @else
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->nombre }}</td>
                            <td>{{ $d->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td>{{ $d->cantidad_total }}</td>
                            <td>{{ $d->cantidad_disponible }}</td>
                            <td>S/. {{ number_format($d->precio, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.disfraces.index', ['editar' => $d->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.disfraces.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este disfraz?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Script para controlar formularios --}}
<script>
    function mostrarFormulario(tipo) {
        const formDisfraz = document.getElementById('formulario-disfraz');
        const formCategoria = document.getElementById('formulario-categoria');

        if (tipo === 'disfraz') {
            formDisfraz.classList.toggle('d-none');
            formCategoria.classList.add('d-none');
        } else {
            formCategoria.classList.toggle('d-none');
            formDisfraz.classList.add('d-none');
        }
    }
</script>
@endsection
