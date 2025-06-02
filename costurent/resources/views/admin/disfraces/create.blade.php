@extends('layouts.admin')

@section('title', 'Registrar Disfraz')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Registrar Nuevo Disfraz</h1>

    <form action="{{ route('admin.disfraces.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria_id" class="form-select" required>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad Total</label>
            <input type="number" name="cantidad_total" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad Disponible</label>
            <input type="number" name="cantidad_disponible" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" name="precio" step="0.01" class="form-control" required>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.disfraces.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection