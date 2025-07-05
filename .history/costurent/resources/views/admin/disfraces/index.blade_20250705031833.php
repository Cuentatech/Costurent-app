<!-- Agrega este carrusel con Bootstrap por cada categoría con filtro como menú -->

@extends('layouts.admin')

@section('title', 'Gestín de Disfraces')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestín de Disfraces</h1>

    {{-- Menú desplegable de categorías --}}
    <div class="mb-4">
        <label class="form-label fw-bold">Filtrar por categoría</label>
        <select id="categoriaSelector" class="form-select" onchange="filtrarCategoria()">
            <option value="all">Todas las categorías</option>
            @foreach($categorias as $categoria)
                <option value="cat-{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Carruseles con Bootstrap por categoría --}}
    @foreach($categorias as $categoria)
        <div class="categoria-carrusel mb-5" id="cat-{{ $categoria->id }}">
            <h3>{{ $categoria->nombre }}</h3>
            <div id="carousel-{{ $categoria->id }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php $chunked = $disfraces->where('categoria_id', $categoria->id)->chunk(3); @endphp
                    @foreach($chunked as $chunkIndex => $chunk)
                        <div class="carousel-item @if($chunkIndex == 0) active @endif">
                            <div class="row">
                                @foreach($chunk as $d)
                                    <div class="col-md-4">
                                        <div class="card mb-3">
                                            <img src="{{ $d->imagen ? asset('storage/' . $d->imagen) : 'https://via.placeholder.com/250x180' }}" class="card-img-top" style="height:180px; object-fit:cover;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $d->nombre }}</h5>
                                                <p class="card-text">{{ Str::limit($d->descripcion, 60) }}</p>
                                                <p class="fw-bold">S/. {{ number_format($d->precio, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $categoria->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $categoria->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    @endforeach
</div>

<script>
function filtrarCategoria() {
    const selected = document.getElementById('categoriaSelector').value;
    document.querySelectorAll('.categoria-carrusel').forEach(c => {
        if (selected === 'all' || c.id === selected) {
            c.style.display = 'block';
        } else {
            c.style.display = 'none';
        }
    });
}
</script>
@endsection
