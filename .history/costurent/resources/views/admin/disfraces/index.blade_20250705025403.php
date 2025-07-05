@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="bg-primary text-white p-4 rounded mb-4">
        <h1>🎭 Gestión de Disfraces</h1>
        <p class="mb-0">Administra tu inventario de manera eficiente</p>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <h6>Filtrar por categoría:</h6>
            <div class="btn-group flex-wrap">
                <button class="btn btn-outline-primary active" data-filter="all">Todos</button>
                @foreach ($categorias as $categoria)
                    <button class="btn btn-outline-primary" data-filter="{{ $categoria->id }}">
                        {{ $categoria->nombre }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="d-flex gap-2 mb-4">
        <button class="btn btn-success" onclick="toggleForm('disfraz')">
            <i class="fas fa-plus"></i> Añadir Disfraz
        </button>
        <button class="btn btn-primary" onclick="toggleForm('categoria')">
            <i class="fas fa-tags"></i> Añadir Categoría
        </button>
    </div>

    <!-- Formulario Disfraz -->
    <div id="form-disfraz" class="card mb-4 d-none">
        <div class="card-header">
            <h5>{{ isset($disfraz) ? 'Editar Disfraz' : 'Nuevo Disfraz' }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($disfraz) ? route('admin.disfraces.update', $disfraz->id) : route('admin.disfraces.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($disfraz)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $disfraz->nombre ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
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
                    <textarea name="descripcion" class="form-control" rows="3">{{ $disfraz->descripcion ?? '' }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cantidad Total</label>
                        <input type="number" name="cantidad_total" class="form-control" value="{{ $disfraz->cantidad_total ?? '' }}" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cantidad Disponible</label>
                        <input type="number" name="cantidad_disponible" class="form-control" value="{{ $disfraz->cantidad_disponible ?? '' }}" min="0" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" step="0.01" class="form-control" value="{{ $disfraz->precio ?? '' }}" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        {{ isset($disfraz) ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeAllForms()">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulario Categoría -->
    <div id="form-categoria" class="card mb-4 d-none">
        <div class="card-header">
            <h5>Nueva Categoría</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categorias.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre de la Categoría</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="closeAllForms()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cards por categoría -->
    <div id="costumes-container">
        @foreach ($categorias as $categoria)
            <div class="category-section mb-4" data-category="{{ $categoria->id }}">
                <h4 class="border-bottom pb-2">{{ $categoria->nombre }}</h4>
                <div class="row g-3">
                    @foreach ($disfraces->where('categoria_id', $categoria->id) as $disfrazCard)
                        <div class="col-md-4">
                            <div class="card h-100">
                                @if($disfrazCard->imagen)
                                    <img src="{{ asset('storage/' . $disfrazCard->imagen) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <span class="text-muted">Sin imagen</span>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $disfrazCard->nombre }}</h5>
                                    <p class="card-text">{{ $disfrazCard->descripcion ?? 'Sin descripción' }}</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-success">S/. {{ number_format($disfrazCard->precio, 2) }}</span>
                                        <small class="text-muted">{{ $disfrazCard->cantidad_disponible }}/{{ $disfrazCard->cantidad_total }}</small>
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
    <div class="card">
        <div class="card-header">
            <h5>Lista de Disfraces</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
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
                        <tr data-category="{{ $d->categoria_id }}">
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->nombre }}</td>
                            <td>{{ $d->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td><span class="badge bg-info">{{ $d->cantidad_total }}</span></td>
                            <td>
                                <span class="badge {{ $d->cantidad_disponible > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $d->cantidad_disponible }}
                                </span>
                            </td>
                            <td>S/. {{ number_format($d->precio, 2) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-warning" onclick="editDisfraz({{ $d->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.disfraces.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este disfraz?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
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
</div>

<script>
// Gestión de formularios
function toggleForm(formType) {
    closeAllForms();
    const form = document.getElementById(`form-${formType}`);
    form.classList.remove('d-none');
}

function closeAllForms() {
    document.getElementById('form-disfraz').classList.add('d-none');
    document.getElementById('form-categoria').classList.add('d-none');
}

// Filtros
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('[data-filter]');
    const categorySection = document.querySelectorAll('.category-section');
    const tableRows = document.querySelectorAll('tbody tr');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Actualizar botón activo
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            // Filtrar secciones
            categorySection.forEach(section => {
                section.style.display = filter === 'all' || section.dataset.category === filter ? 'block' : 'none';
            });
            
            // Filtrar tabla
            tableRows.forEach(row => {
                row.style.display = filter === 'all' || row.dataset.category === filter ? 'table-row' : 'none';
            });
        });
    });
});

// Función para editar (simplificada)
function editDisfraz(id) {
    window.location.href = `/admin/disfraces/${id}/edit`;
}
</script>
@endsection