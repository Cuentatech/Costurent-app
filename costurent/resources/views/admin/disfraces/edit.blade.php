@extends('layouts.admin')

@section('title', 'Editar Disfraz')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Editar Disfraz</h1>

        <form action="{{ route('admin.disfraces.update', $disfraz->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $disfraz->nombre }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                {{-- Filtros de búsqueda --}}
                <form method="GET" action="{{ route('admin.disfraces.index') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                            value="{{ request('nombre') }}">
                    </div>

                    <div class="col-md-4">
                        <select name="categoria_id" class="form-select">
                            <option value="">-- Todas las categorías --</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @if(request('categoria_id') == $categoria->id) selected
                                @endif>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                        <a href="{{ route('admin.disfraces.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                    </div>
                </form>

                <textarea name="descripcion" class="form-control">{{ $disfraz->descripcion }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-select" required>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->id }}" @if($cat->id == $disfraz->categoria_id) selected @endif>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Cantidad Total</label>
                <input type="number" name="cantidad_total" class="form-control" value="{{ $disfraz->cantidad_total }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cantidad Disponible</label>
                <input type="number" name="cantidad_disponible" class="form-control"
                    value="{{ $disfraz->cantidad_disponible }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" name="precio" step="0.01" class="form-control" value="{{ $disfraz->precio }}" required>
            </div>

            <button class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.disfraces.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection