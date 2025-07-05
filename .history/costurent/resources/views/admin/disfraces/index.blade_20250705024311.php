@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<style>
    /* Estilos simplificados y modernos */
    .page-header {
        background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
        color: white;
        padding: 2rem 0;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .filter-carousel {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
        overflow-x: auto;
        white-space: nowrap;
    }
    
    .filter-carousel::-webkit-scrollbar {
        height: 6px;
    }
    
    .filter-carousel::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .filter-carousel::-webkit-scrollbar-thumb {
        background: #6c5ce7;
        border-radius: 10px;
    }
    
    .filter-btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        margin-right: 1rem;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
        font-weight: 500;
    }
    
    .filter-btn:hover {
        background: #6c5ce7;
        color: white;
        border-color: #6c5ce7;
        transform: translateY(-2px);
    }
    
    .filter-btn.active {
        background: #6c5ce7;
        color: white;
        border-color: #6c5ce7;
    }
    
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
</style>

<div class="container mt-4">
    <!-- Header -->
    <div class="page-header text-center">
        <h1 class="mb-2">🎭 Gestión de Disfraces</h1>
        <p class="mb-0">Administra tu inventario de manera eficiente</p>
    </div>

    <!-- Filtro Carrusel -->
    <div class="filter-carousel">
        <h6 class="mb-3">Filtrar por categoría:</h6>
        <div class="d-flex">
            <a href="#" class="filter-btn active" data-category="all">
                <i class="fas fa-th-large"></i> Todos
            </a>
            @foreach ($categorias as $categoria)
                <a href="#" class="filter-btn" data-category="{{ $categoria->id }}">
                    <i class="fas fa-tag"></i> {{ $categoria->nombre }}
                </a>
            @endforeach
        </div>
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
    // Gestión de formularios - Solo uno a la vez
    function toggleForm(formType) {
        const formDisfraz = document.getElementById('form-disfraz');
        const formCategoria = document.getElementById('form-categoria');
        
        // Cerrar todos los formularios primero
        closeAllForms();
        
        // Abrir el formulario solicitado
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
    
    // Filtros del carrusel
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const categorySection = document.querySelectorAll('.category-section');
        const tableRows = document.querySelectorAll('.table-row');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Actualizar botón activo
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const category = this.dataset.category;
                
                // Filtrar cards
                categorySection.forEach(section => {
                    if (category === 'all' || section.dataset.category === category) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
                
                // Filtrar tabla
                tableRows.forEach(row => {
                    if (category === 'all' || row.dataset.category === category) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
        
        // Edición inline
        const editBtns = document.querySelectorAll('.edit-btn');
        let currentEditingRow = null;
        
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = this.dataset.id;
                
                // Si ya hay una fila en edición, cancelar
                if (currentEditingRow && currentEditingRow !== row) {
                    cancelEdit(currentEditingRow);
                }
                
                // Si la fila actual ya está en edición, cancelar
                if (currentEditingRow === row) {
                    cancelEdit(row);
                    return;
                }
                
                startEdit(row, id);
                currentEditingRow = row;
            });
        });
        
        function startEdit(row, id) {
            row.classList.add('edit-mode');
            const cells = row.querySelectorAll('.editable-cell');
            
            cells.forEach(cell => {
                const field = cell.dataset.field;
                const original = cell.dataset.original;
                
                if (field === 'nombre') {
                    cell.innerHTML = `<input type="text" class="edit-input" value="${original}">`;
                } else if (field === 'categoria_id') {
                    let options = '<option value="">Seleccionar</option>';
                    @foreach ($categorias as $cat)
                        options += `<option value="{{ $cat->id }}" ${original == '{{ $cat->id }}' ? 'selected' : ''}>{{ $cat->nombre }}</option>`;
                    @endforeach
                    cell.innerHTML = `<select class="edit-select">${options}</select>`;
                } else if (field === 'cantidad_total' || field === 'cantidad_disponible') {
                    cell.innerHTML = `<input type="number" class="edit-input" value="${original}" min="0">`;
                } else if (field === 'precio') {
                    cell.innerHTML = `<input type="number" class="edit-input" value="${original}" step="0.01" min="0">`;
                }
            });
            
            // Cambiar botón de editar por guardar/cancelar
            const actionCell = row.querySelector('td:last-child');
            actionCell.innerHTML = `
                <div class="d-flex gap-2">
                    <button class="btn-save" onclick="saveEdit(this, ${id})">
                        <i class="fas fa-check"></i> Guardar
                    </button>
                    <button class="btn-cancel" onclick="cancelEdit(this.closest('tr'))">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            `;
        }
        
        window.saveEdit = function(btn, id) {
            const row = btn.closest('tr');
            const cells = row.querySelectorAll('.editable-cell');
            const data = { _token: '{{ csrf_token() }}', _method: 'PUT' };
            
            cells.forEach(cell => {
                const field = cell.dataset.field;
                const input = cell.querySelector('input, select');
                if (input) {
                    data[field] = input.value;
                }
            });
            
            // Enviar datos via AJAX
            fetch(`/admin/disfraces/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    location.reload(); // Recargar para mostrar cambios
                } else {
                    alert('Error al guardar los cambios');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar los cambios');
            });
        }
        
        window.cancelEdit = function(row) {
            const cells = row.querySelectorAll('.editable-cell');
            
            cells.forEach(cell => {
                const field = cell.dataset.field;
                const original = cell.dataset.original;
                
                if (field === 'nombre') {
                    cell.innerHTML = original;
                } else if (field === 'categoria_id') {
                    const categoriaName = getCategoryName(original);
                    cell.innerHTML = categoriaName;
                } else if (field === 'cantidad_total' || field === 'cantidad_disponible') {
                    const badgeClass = field === 'cantidad_total' ? 'bg-info' : 
                                     (original > 0 ? 'bg-success' : 'bg-danger');
                    cell.innerHTML = `<span class="badge ${badgeClass}">${original}</span>`;
                } else if (field === 'precio') {
                    cell.innerHTML = `<strong>S/. ${parseFloat(original).toFixed(2)}</strong>`;
                }
            });
            
            // Restaurar botones originales
            const actionCell = row.querySelector('td:last-child');
            const deleteForm = row.querySelector('form').outerHTML;
            actionCell.innerHTML = `
                <div class="d-flex gap-2">
                    <button class="btn btn-action btn-warning-modern edit-btn" data-id="${row.dataset.id}">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    ${deleteForm}
                </div>
            `;
            
            // Reactivar eventos
            const newEditBtn = actionCell.querySelector('.edit-btn');
            newEditBtn.addEventListener('click', function() {
                startEdit(row, this.dataset.id);
                currentEditingRow = row;
            });
            
            row.classList.remove('edit-mode');
            currentEditingRow = null;
        }
        
        function getCategoryName(categoryId) {
            const categories = {
                @foreach ($categorias as $cat)
                    '{{ $cat->id }}': '{{ $cat->nombre }}',
                @endforeach
            };
            return categories[categoryId] || 'Sin categoría';
        }
    });
</script>
@endsection