@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Disfraces</h1>

    {{-- Filtro de Categoría y Buscador --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.disfraces.index') }}">
                <div class="input-group">
                    <select class="form-select" name="categoria_filter" onchange="this.form.submit()">
                        <option value="">Todas las Categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria_filter') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.disfraces.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar disfraz..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Botones para alternar formularios --}}
    <div class="mb-3 d-flex gap-3">
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
                        @foreach ($categorias as $cat)
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
                    <input type="number" name="precio" step="0.01" class="form-control" required>
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
                <label class="form-label">Nombre de la Categoría</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Categoría</button>
        </form>
    </div>

    {{-- Carrusel por categoría --}}
    @foreach($categorias as $categoria)
        @php
            $disfracesFiltrados = $disfraces->where('categoria_id', $categoria->id);
            if(request('categoria_filter') && request('categoria_filter') != $categoria->id) continue;
        @endphp

        @if($disfracesFiltrados->count())
            <h3 class="mt-5">{{ $categoria->nombre }}</h3>
            <div id="carouselCat{{ $categoria->id }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($disfracesFiltrados->chunk(3) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $d)
                                    <div class="col-md-4">
                                        <div class="card h-100 shadow-sm">
                                            @if($d->imagen)
                                                <img src="{{ asset('storage/' . $d->imagen) }}" class="card-img-top" alt="Imagen">
                                            @else
                                                <img src="https://via.placeholder.com/300x200?text=Sin+imagen" class="card-img-top" alt="Sin imagen">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $d->nombre }}</h5>
                                                <p class="card-text">{{ $d->descripcion ?? 'Sin descripción' }}</p>
                                                <p class="text-muted">Precio: S/. {{ number_format($d->precio, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCat{{ $categoria->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselCat{{ $categoria->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        @endif
    @endforeach
</div>

<script>
    function mostrarFormulario(tipo) {
        const disfrazForm = document.getElementById('formulario-disfraz');
        const categoriaForm = document.getElementById('formulario-categoria');

        if (tipo === 'disfraz') {
            disfrazForm.classList.remove('d-none');
            categoriaForm.classList.add('d-none');
        } else {
            categoriaForm.classList.remove('d-none');
            disfrazForm.classList.add('d-none');
        }
    }
</script>
@endsection
