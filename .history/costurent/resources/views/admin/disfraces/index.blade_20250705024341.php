@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<style>
    /* Estilos personalizados */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        border-radius: 20px;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="90" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        animation: float 20s infinite linear;
        pointer-events: none;
    }
    
    @keyframes float {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    
    .category-section {
        margin-bottom: 3rem;
    }
    
    .category-title {
        background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: bold;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
    }
    
    .category-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
        border-radius: 2px;
    }
    
    .costume-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        position: relative;
    }
    
    .costume-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .costume-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(45deg, #FF6B6B, #4ECDC4, #45B7D1, #96CEB4);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    
    .costume-card .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .costume-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .costume-card .card-body {
        padding: 1.5rem;
    }
    
    .costume-card .card-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .costume-card .card-text {
        color: #7f8c8d;
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    .category-badge {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        justify-content: center;
    }
    
    .btn-custom {
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .btn-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-custom:hover::before {
        left: 100%;
    }
    
    .btn-add-costume {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .btn-add-costume:hover {
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        transform: translateY(-2px);
    }
    
    .btn-add-category {
        background: linear-gradient(45deg, #007bff, #6610f2);
        color: white;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }
    
    .btn-add-category:hover {
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        transform: translateY(-2px);
    }
    
    .form-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        background: white;
        overflow: hidden;
        position: relative;
    }
    
    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
    }
    
    .form-card .card-body {
        padding: 2rem;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .data-table {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .table-dark {
        background: linear-gradient(45deg, #2c3e50, #3498db);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .btn-action {
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .btn-edit {
        background: linear-gradient(45deg, #ffc107, #fd7e14);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(45deg, #dc3545, #e83e8c);
        color: white;
    }
    
    .price-tag {
        font-weight: bold;
        color: #28a745;
    }
    
    .slide-in {
        animation: slideIn 0.5s ease-out;
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
    
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<div class="container mt-4">
    <!-- Hero Section -->
    <div class="hero-section text-center slide-in">
        <div class="container">
            <h1 class="display-4 mb-3">🎭 Gestión de Disfraces</h1>
            <p class="lead">Administra tu inventario de disfraces de manera fácil y eficiente</p>
        </div>
    </div>

    <!-- Cards por categoría -->
    @foreach ($categorias as $categoria)
        <div class="category-section fade-in">
            <h3 class="category-title">{{ $categoria->nombre }}</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                @foreach ($disfraces->where('categoria_id', $categoria->id) as $disfrazCard)
                    <div class="col">
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="category-badge">{{ $categoria->nombre }}</span>
                                    <span class="price-tag">S/. {{ number_format($disfrazCard->precio, 2) }}</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-box"></i> {{ $disfrazCard->cantidad_disponible }}/{{ $disfrazCard->cantidad_total }} disponibles
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- Botones de acción -->
    <div class="action-buttons">
        <button class="btn btn-custom btn-add-costume"
            onclick="toggleForm('formulario-disfraz')">
            <i class="fas fa-plus"></i> Añadir Disfraz
        </button>
        <button class="btn btn-custom btn-add-category"
            onclick="toggleForm('formulario-categoria')">
            <i class="fas fa-tags"></i> Añadir Categoría
        </button>
    </div>

    <!-- Formulario Disfraz -->
    <div id="formulario-disfraz" class="{{ isset($disfraz) ? 'slide-in' : 'd-none' }} mb-5">
        <div class="card form-card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="fas fa-mask"></i> {{ isset($disfraz) ? 'Editar Disfraz' : 'Nuevo Disfraz' }}
                </h4>
                <form method="POST"
                    action="{{ isset($disfraz) ? route('admin.disfraces.update', $disfraz->id) : route('admin.disfraces.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if(isset($disfraz)) @method('PUT') @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-tag"></i> Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $disfraz->nombre ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-list"></i> Categoría</label>
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
                        <label class="form-label"><i class="fas fa-align-left"></i> Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Describe el disfraz...">{{ $disfraz->descripcion ?? '' }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-boxes"></i> Cantidad Total</label>
                            <input type="number" name="cantidad_total" class="form-control"
                                value="{{ $disfraz->cantidad_total ?? '' }}" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-box-open"></i> Cantidad Disponible</label>
                            <input type="number" name="cantidad_disponible" class="form-control"
                                value="{{ $disfraz->cantidad_disponible ?? '' }}" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-dollar-sign"></i> Precio</label>
                            <input type="number" name="precio" step="0.01" class="form-control"
                                value="{{ $disfraz->precio ?? '' }}" min="0" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-image"></i> Imagen</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF (máx. 2MB)</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-custom btn-add-costume">
                            <i class="fas fa-save"></i> {{ isset($disfraz) ? 'Actualizar' : 'Guardar' }}
                        </button>
                        <button type="button" class="btn btn-secondary btn-custom" onclick="toggleForm('formulario-disfraz')">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Formulario Categoría -->
    <div id="formulario-categoria" class="d-none mb-5">
        <div class="card form-card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="fas fa-tags"></i> Nueva Categoría
                </h4>
                <form method="POST" action="{{ route('admin.categorias.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-tag"></i> Nombre de la Categoría</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Superhéroes, Princesas, Terror..." required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-custom btn-add-category">
                            <i class="fas fa-save"></i> Guardar Categoría
                        </button>
                        <button type="button" class="btn btn-secondary btn-custom" onclick="toggleForm('formulario-categoria')">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabla de disfraces -->
    <div class="data-table">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-mask"></i> Nombre</th>
                    <th><i class="fas fa-list"></i> Categoría</th>
                    <th><i class="fas fa-boxes"></i> Total</th>
                    <th><i class="fas fa-box-open"></i> Disponible</th>
                    <th><i class="fas fa-dollar-sign"></i> Precio</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disfraces as $d)
                    <tr>
                        <td><strong>{{ $d->id }}</strong></td>
                        <td>{{ $d->nombre }}</td>
                        <td>
                            <span class="category-badge">{{ $d->categoria->nombre ?? 'Sin categoría' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $d->cantidad_total }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $d->cantidad_disponible > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $d->cantidad_disponible }}
                            </span>
                        </td>
                        <td class="price-tag">S/. {{ number_format($d->precio, 2) }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.disfraces.edit', $d->id) }}" class="btn btn-sm btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('admin.disfraces.destroy', $d->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este disfraz?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-action btn-delete">
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
    function toggleForm(formId) {
        const form = document.getElementById(formId);
        if (form.classList.contains('d-none')) {
            form.classList.remove('d-none');
            form.classList.add('slide-in');
            form.scrollIntoView({ behavior: 'smooth' });
        } else {
            form.classList.add('d-none');
            form.classList.remove('slide-in');
        }
    }

    // Animación de entrada para las cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.costume-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeIn 0.6s ease-out';
                }
            });
        });

        cards.forEach(card => {
            observer.observe(card);
        });
    });
</script>
@endsection