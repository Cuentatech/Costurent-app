@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
<style>
    /* Estilos para el header principal */
    .main-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        border-radius: 20px;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .main-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="60" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .main-header .content {
        position: relative;
        z-index: 1;
    }
    
    .main-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .main-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
    }
    
    /* Estilos para el header de sección */
    .section-header {
        background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
        color: white;
        padding: 1.5rem 0;
        border-radius: 15px;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    /* Carrusel de filtros mejorado */
    .filter-carousel-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .filter-carousel-wrapper {
        position: relative;
        overflow: hidden;
    }
    
    .filter-carousel {
        display: flex;
        transition: transform 0.3s ease;
        gap: 1rem;
    }
    
    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
        font-weight: 500;
        flex-shrink: 0;
        cursor: pointer;
    }
    
    .filter-btn:hover {
        background: #6c5ce7;
        color: white;
        border-color: #6c5ce7;
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .filter-btn.active {
        background: #6c5ce7;
        color: white;
        border-color: #6c5ce7;
        box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
    }
    
    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #6c5ce7;
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .carousel-btn:hover {
        background: #5a4fcf;
        transform: translateY(-50%) scale(1.1);
    }
    
    .carousel-btn:disabled {
        background: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
        transform: translateY(-50%) scale(1);
    }
    
    .carousel-btn.prev {
        left: -20px;
    }
    
    .carousel-btn.next {
        right: -20px;
    }
    
    /* Indicadores del carrusel */
    .carousel-indicators {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .carousel-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #e9ecef;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .carousel-indicator.active {
        background: #6c5ce7;
    }
    
    /* Resto de estilos existentes */
    .category-section {
        margin-bottom: 2rem;
    }
    
    .category-title {
        color: #2d3436;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #6c5ce7;
        display: inline-block;
    }
    
    .costume-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .costume-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .costume-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    
    .costume-card .card-body {
        padding: 1.25rem;
    }
    
    .costume-card .card-title {
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 0.5rem;
    }
    
    .price-badge {
        background: #00b894;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .stock-info {
        font-size: 0.85rem;
        color: #636e72;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        justify-content: center;
    }
    
    .btn-modern {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
    }
    
    .btn-success-modern {
        background: #00b894;
        color: white;
    }
    
    .btn-success-modern:hover {
        background: #00a085;
        color: white;
    }
    
    .btn-primary-modern {
        background: #0984e3;
        color: white;
    }
    
    .btn-primary-modern:hover {
        background: #0770c4;
        color: white;
    }
    
    .form-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .form-container.slide-in {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem;
        transition: border-color 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #6c5ce7;
        box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
    }
    
    .data-table {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .table-dark {
        background: #2d3436;
    }
    
    .table th {
        border: none;
        font-weight: 600;
    }
    
    .table td {
        border: none;
        vertical-align: middle;
    }
    
    .table tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        border: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-warning-modern {
        background: #fdcb6e;
        color: #2d3436;
    }
    
    .btn-warning-modern:hover {
        background: #f39c12;
        color: white;
    }
    
    .btn-danger-modern {
        background: #e17055;
        color: white;
    }
    
    .btn-danger-modern:hover {
        background: #d63031;
    }
    
    .hidden {
        display: none !important;
    }
    
    /* Estilos para edición inline */
    .edit-input {
        border: 2px solid #6c5ce7;
        border-radius: 5px;
        padding: 0.4rem;
        font-size: 0.9rem;
        width: 100%;
    }
    
    .edit-select {
        border: 2px solid #6c5ce7;
        border-radius: 5px;
        padding: 0.4rem;
        font-size: 0.9rem;
        width: 100%;
    }
    
    .edit-textarea {
        border: 2px solid #6c5ce7;
        border-radius: 5px;
        padding: 0.4rem;
        font-size: 0.9rem;
        width: 100%;
        resize: vertical;
        min-height: 60px;
    }
    
    .edit-mode {
        background-color: #f8f9ff !important;
    }
    
    .btn-save {
        background: #00b894;
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        margin-right: 0.5rem;
    }
    
    .btn-cancel {
        background: #636e72;
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
    }
    
    .btn-save:hover {
        background: #00a085;
    }
    
    .btn-cancel:hover {
        background: #2d3436;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .main-title {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .carousel-btn {
            width: 35px;
            height: 35px;
        }
        
        .carousel-btn.prev {
            left: -15px;
        }
        
        .carousel-btn.next {
            right: -15px;
        }
        
        .filter-btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container mt-4">
    <!-- Header Principal -->
    <div class="main-header">
        <div class="content text-center">
            <h1 class="main-title">🎮 Panel de Administración</h1>
            <p class="main-subtitle">Gestiona tu plataforma desde aquí</p>
        </div>
    </div>

    <!-- Header de Sección -->
    <div class="section-header">
        <h2 class="section-title">🎭 Gestión de Disfraces</h2>
        <p class="section-subtitle">Administra tu inventario de manera eficiente</p>
    </div>

    <!-- Carrusel de Filtros Mejorado -->
    <div class="filter-carousel-container">
        <h6 class="mb-3"><i class="fas fa-filter"></i> Filtrar por categoría:</h6>
        <div class="filter-carousel-wrapper">
            <button class="carousel-btn prev" id="prevBtn" onclick="moveCarousel(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="filter-carousel" id="filterCarousel">
                <a href="#" class="filter-btn active" data-category="all">
                    <i class="fas fa-th-large"></i> Todos
                </a>
                @foreach ($categorias as $categoria)
                    <a href="#" class="filter-btn" data-category="{{ $categoria->id }}">
                        <i class="fas fa-tag"></i> {{ $categoria->nombre }}
                    </a>
                @endforeach
            </div>
            <button class="carousel-btn next" id="nextBtn" onclick="moveCarousel(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <div class="carousel-indicators" id="carouselIndicators"></div>
    </div>

    <!-- Botones de acción -->
    <div class="action-buttons">
        <button class="btn btn-modern btn-success-modern" onclick="toggleForm('disfraz')">
            <i class="fas fa-plus"></i> Añadir Disfraz
        </button>
        <button class="btn btn-modern btn-primary-modern" onclick="toggleForm('categoria')">
            <i class="fas fa-tags"></i> Añadir Categoría
        </button>
    </div>

    <!-- Formulario Disfraz -->
    <div id="form-disfraz" class="form-container hidden">
        <h4 class="mb-4">
            <i class="fas fa-mask"></i> {{ isset($disfraz) ? 'Editar Disfraz' : 'Nuevo Disfraz' }}
        </h4>
        <form method="POST"
            action="{{ isset($disfraz) ? route('admin.disfraces.update', $disfraz->id) : route('admin.disfraces.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if(isset($disfraz)) @method('PUT') @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $disfraz->nombre ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" @if(isset($disfraz) && $cat->id == $disfraz->categoria_id) selected @endif>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" placeholder="Describe el disfraz...">{{ $disfraz->descripcion ?? '' }}</textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Cantidad Total</label>
                    <input type="number" name="cantidad_total" class="form-control"
                        value="{{ $disfraz->cantidad_total ?? '' }}" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cantidad Disponible</label>
                    <input type="number" name="cantidad_disponible" class="form-control"
                        value="{{ $disfraz->cantidad_disponible ?? '' }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Precio</label>
                    <input type="number" name="precio" step="0.01" class="form-control"
                        value="{{ $disfraz->precio ?? '' }}" min="0" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-modern btn-success-modern">
                    <i class="fas fa-save"></i> {{ isset($disfraz) ? 'Actualizar' : 'Guardar' }}
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeAllForms()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </form>
    </div>

    <!-- Formulario Categoría -->
    <div id="form-categoria" class="form-container hidden">
        <h4 class="mb-4">
            <i class="fas fa-tags"></i> Nueva Categoría
        </h4>
        <form method="POST" action="{{ route('admin.categorias.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nombre de la Categoría</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ej: Superhéroes, Princesas, Terror..." required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-modern btn-primary-modern">
                    <i class="fas fa-save"></i> Guardar Categoría
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeAllForms()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </form>
    </div>

    <!-- Cards por categoría -->
    <div id="costumes-container">
        @foreach ($categorias as $categoria)
            <div class="category-section" data-category="{{ $categoria->id }}">
                <h3 class="category-title">{{ $categoria->nombre }}</h3>
                <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                    @foreach ($disfraces->where('categoria_id', $categoria->id) as $disfrazCard)
                        <div class="col costume-item" data-category="{{ $categoria->id }}">
                            <div class="card costume-card h-100">
                                @if($disfrazCard->imagen)
                                    <img src="{{ asset('storage/' . $disfrazCard->imagen) }}" class="card-img-top"
                                        alt="Imagen de {{ $disfrazCard->nombre }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Sin+imagen&bg=f8f9fa&color=6c757d" class="card-img-top" alt="Sin imagen">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $disfrazCard->nombre }}</h5>
                                    <p class="card-text">{{ $disfrazCard->descripcion ?? 'Sin descripción disponible' }}</p>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="price-badge">S/. {{ number_format($disfrazCard->precio, 2) }}</span>
                                        <div class="stock-info">
                                            <i class="fas fa-box"></i> {{ $disfrazCard->cantidad_disponible }}/{{ $disfrazCard->cantidad_total }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabla de disfraces -->
    <div class="data-table">
        <table class="table table-hover align-middle mb-0">
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
                @foreach ($disfraces as $d)
                    <tr class="table-row" data-category="{{ $d->categoria_id }}" data-id="{{ $d->id }}">
                        <td><strong>{{ $d->id }}</strong></td>
                        <td class="editable-cell" data-field="nombre" data-original="{{ $d->nombre }}">{{ $d->nombre }}</td>
                        <td class="editable-cell" data-field="categoria_id" data-original="{{ $d->categoria_id }}">{{ $d->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td class="editable-cell" data-field="cantidad_total" data-original="{{ $d->cantidad_total }}">
                            <span class="badge bg-info">{{ $d->cantidad_total }}</span>
                        </td>
                        <td class="editable-cell" data-field="cantidad_disponible" data-original="{{ $d->cantidad_disponible }}">
                            <span class="badge {{ $d->cantidad_disponible > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $d->cantidad_disponible }}
                            </span>
                        </td>
                        <td class="editable-cell" data-field="precio" data-original="{{ $d->precio }}"><strong>S/. {{ number_format($d->precio, 2) }}</strong></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-action btn-warning-modern edit-btn" data-id="{{ $d->id }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="{{ route('admin.disfraces.destroy', $d->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este disfraz?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-action btn-danger-modern">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Variables del carrusel
    let currentPosition = 0;
    let itemsPerView = 3;
    let totalItems = 0;
    let maxPosition = 0;

    // Inicializar carrusel
    document.addEventListener('DOMContentLoaded', function() {
        initCarousel();
        initFilters();
        initEditFunctionality();
    });

    function initCarousel() {
        const carousel = document.getElementById('filterCarousel');
        const items = carousel.querySelectorAll('.filter-btn');
        totalItems = items.length;
        
        // Calcular items por vista según el ancho de pantalla
        updateItemsPerView();
        
        // Calcular posición máxima
        maxPosition = Math.max(0, totalItems - itemsPerView);
        
        // Generar indicadores
        generateIndicators();
        
        // Actualizar estado inicial
        updateCarouselState();
        
        // Evento para cambio de tamaño de ventana
        window.addEventListener('resize', function() {
            updateItemsPerView();
            maxPosition = Math.max(0, totalItems - itemsPerView);
            updateCarouselState();
        });
    }

    function updateItemsPerView() {
        const containerWidth = document.querySelector('.filter-carousel-wrapper').offsetWidth;
        if (containerWidth < 576) {
            itemsPerView = 1;
        } else if (containerWidth < 768) {
            itemsPerView = 2;
        } else if (containerWidth < 992) {
            itemsPerView = 3;
        } else {
            itemsPerView = 4;
        }
    }

    function generateIndicators() {
        const indicatorsContainer = document.getElementById('carouselIndicators');
        indicatorsContainer.innerHTML = '';
        
        const totalPages = Math.ceil(totalItems / itemsPerView);
        
        for (let i = 0; i < totalPages; i++) {
            const indicator = document.createElement('div');
            indicator.className = 'carousel-indicator';
            indicator.onclick = () => goToPage(i);
            indicatorsContainer.appendChild(indicator);
        }
    }

    function moveCarousel(direction) {
        const newPosition = currentPosition + direction;
        
        if (newPosition >= 0 && newPosition <= maxPosition) {
            currentPosition = newPosition;
            updateCarouselState();
        }
    }

    function goToPage(pageIndex) {
        currentPosition = pageIndex * itemsPerView;
        if (currentPosition > maxPosition) {
            currentPosition = maxPosition;
        }
        updateCarouselState();
    }

    function updateCarouselState() {
        const carousel = document.getElementById('filterCarousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const indicators = document.querySelectorAll('.carousel-indicator');
        
        // Mover carrusel
        const translateX = -currentPosition * (100 / itemsPerView);
        carousel.style.transform = `translateX(${translateX}%)`;
        
        // Actualizar botones
        prevBtn.disabled = currentPosition === 0;
        nextBtn.disabled = currentPosition >= maxPosition;
        
        // Actualizar indicadores
        const currentPage = Math.floor(currentPosition / itemsPerView);
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentPage);
        });
    }

    // Gestión de formularios
    function toggleForm(formType) {
        const formDisfraz = document.getElementById('form-disfraz');
        const formCategoria = document.getElementById('form-categoria');
        
        closeAllForms();
        
        if (formType === 'disfraz') {
            formDisfraz.classList.remove('hidden');
            formDisfraz.classList.add('slide-in');
            formDisfraz.scrollIntoView({ behavior: 'smooth' });
        } else if (formType === 'categoria') {
            formCategoria.classList.remove('hidden');
            formCategoria.classList.add('slide-in');
            formCategoria.scrollIntoView({ behavior: 'smooth' });
        }
    }
    
    function closeAllForms() {
        document.getElementById('form-disfraz').classList.add('hidden');
        document.getElementById('form-categoria').classList.add('hidden');
    }

    // Filtros
    function initFilters() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const categorySection = document.querySelectorAll('.category-section');
        const tableRows = document.querySelectorAll('.table-row');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                filterBtns.forEach(b => b.classList.remove('active'));