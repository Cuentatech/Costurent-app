
@extends('layouts.cliente')

@section('title', 'Alquilar Disfraz')

@section('content')
<div class="container">
    <h2 class="mb-4">Alquilar: {{ $disfraz->nombre }}</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <img src="{{ $disfraz->imagen_url ?? 'https://via.placeholder.com/300x400?text=Sin+imagen' }}" alt="{{ $disfraz->nombre }}" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-8">
            <p><strong>Descripción:</strong> {{ $disfraz->descripcion }}</p>
            <p><strong>Precio por día:</strong> S/ {{ number_format($disfraz->precio, 2) }}</p>
            <p><strong>Disponibles:</strong> {{ $disfraz->cantidad_disponible }} unidades</p>

            <form method="POST" action="{{ route('cliente.alquiler.guardar') }}">
                @csrf
                <input type="hidden" name="disfraz_id" value="{{ $disfraz->id }}">

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" value="1" min="1" max="{{ $disfraz->cantidad_disponible }}" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                    <input type="date" class="form-control" name="fecha_inicio" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de fin</label>
                    <input type="date" class="form-control" name="fecha_fin" required>
                </div>

                <button type="submit" class="btn btn-success">Confirmar Alquiler</button>
            </form>
        </div>
    </div>
</div>
@endsection