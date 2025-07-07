@extends('layouts.cliente')

@section('title', 'Catálogo de Disfraces')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Catálogo de Disfraces</h2>

    <!-- 🔍 Filtros -->
    <form method="GET" action="{{ route('cliente.catalogo') }}" class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control" placeholder="Buscar por nombre de disfraz">
        </div>
        <div class="col-md-4">
            <select name="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <!-- 🎭 Disfraces agrupados -->
    @forelse ($disfracesAgrupados as $categoriaNombre => $disfraces)
        <h4 class="mb-3">{{ $categoriaNombre }}</h4>
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            @foreach ($disfraces as $disfraz)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if($disfraz->imagen)
                            <img src="{{ asset('storage/' . $disfraz->imagen) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Imagen de {{ $disfraz->nombre }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text={{ urlencode($disfraz->nombre) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Sin imagen">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $disfraz->nombre }}</h5>
                            <p class="card-text">{{ $disfraz->descripcion }}</p>
                            <p class="fw-semibold">Precio: S/ {{ number_format($disfraz->precio, 2) }}</p>
                        </div>

                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('cliente.alquiler.form', $disfraz->id) }}" class="btn btn-primary w-100">Alquilar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="alert alert-info text-center">
            No se encontraron resultados para tu búsqueda.
        </div>
    @endforelse
</div>
@endsection
