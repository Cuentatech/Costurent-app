@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<style>
    .page-header { background: linear-gradient(135deg, #6c5ce7, #a29bfe); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; text-align: center; }
    .filter-carousel { background: #fff; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding: 1rem; margin-bottom: 2rem; overflow-x: auto; white-space: nowrap; }
    .filter-btn { display: inline-block; padding: .6rem 1.2rem; margin-right: .5rem; border: 2px solid #e9ecef; border-radius: 25px; color: #6c757d; text-decoration: none; transition: .3s; font-weight: 500; }
    .filter-btn:hover, .filter-btn.active { background: #6c5ce7; color: white; border-color: #6c5ce7; }

    .costume-card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; transition: .3s; }
    .costume-card:hover { transform: translateY(-5px); }
    .card-img-top { height: 200px; object-fit: cover; }
    .price-badge { background: #00b894; color: white; padding: 0.3rem .7rem; border-radius: 1rem; font-size: 0.85rem; }

    .action-buttons { display: flex; gap: 1rem; justify-content: center; margin-bottom: 2rem; }
    .btn-modern { padding: 0.7rem 1.5rem; border-radius: 25px; font-weight: 500; border: none; }
    .btn-success-modern { background: #00b894; color: white; }
    .btn-primary-modern { background: #0984e3; color: white; }

    .form-container { background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding: 2rem; margin-bottom: 2rem; }
    .form-control, .form-select { border-radius: 10px; padding: 0.7rem; }
</style>

<div class="container mt-4">
    <div class="page-header">
        <h1>🎭 Gestión de Disfraces</h1>
        <p>Administra tu inventario de manera eficiente</p>
    </div>

    <div class="filter-carousel">
        <strong class="me-2">Filtrar:</strong>
        <a href="#" class="filter-btn active" data-category="all">Todos</a>
        @foreach ($categorias as $categoria)
            <a href="#" class="filter-btn" data-category="{{ $categoria->id }}">{{ $categoria->nombre }}</a>
        @endforeach
    </div>

    <div class="action-buttons">
        <button class="btn btn-modern btn-success-modern" onclick="toggleForm('disfraz')">+ Disfraz</button>
        <button class="btn btn-modern btn-primary-modern" onclick="toggleForm('categoria')">+ Categoría</button>
    </div>

    @include('admin.disfraces.form-disfraz', ['disfraz' => $disfraz ?? null, 'categorias' => $categorias])
    @include('admin.disfraces.form-categoria')

    <div id="costumes-container">
        @foreach ($categorias as $categoria)
            <div class="mb-5 category-section" data-category="{{ $categoria->id }}">
                <h4 class="mb-3">{{ $categoria->nombre }}</h4>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($disfraces->where('categoria_id', $categoria->id) as $d)
                        <div class="col costume-item" data-category="{{ $categoria->id }}">
                            <div class="card costume-card h-100">
                                <img src="{{ $d->imagen ? asset('storage/' . $d->imagen) : 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $d->nombre }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $d->nombre }}</h5>
                                    <p>{{ $d->descripcion ?? 'Sin descripción' }}</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="price-badge">S/. {{ number_format($d->precio, 2) }}</span>
                                        <small>{{ $d->cantidad_disponible }}/{{ $d->cantidad_total }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @include('admin.disfraces.tabla', ['disfraces' => $disfraces])
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const cat = this.dataset.category;
                document.querySelectorAll('.category-section, .costume-item, .table-row').forEach(el => {
                    el.style.display = (cat === 'all' || el.dataset.category === cat) ? '' : 'none';
                });
            });
        });
    });

    function toggleForm(id) {
        document.getElementById('form-disfraz')?.classList.add('d-none');
        document.getElementById('form-categoria')?.classList.add('d-none');
        document.getElementById('form-' + id)?.classList.remove('d-none');
        document.getElementById('form-' + id)?.scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endpush
@endsection
