@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Gestión de Disfraces</h1>

        {{-- Carrusel de filtros con flechas --}}
        <div class="d-flex align-items-center mb-4">
            <button class="btn btn-outline-secondary me-2" id="prevBtn">&#10094;</button>
            <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex flex-nowrap overflow-auto" id="carouselCategorias">
                    <button class="btn btn-outline-dark me-2 filter-btn active" data-category="all">Todos</button>
                    @foreach ($categorias as $categoria)
                        <button class="btn btn-outline-dark me-2 filter-btn" data-category="{{ $categoria->id }}">
                            {{ $categoria->nombre }}
                        </button>
                    @endforeach
                </div>
            </div>
            <button class="btn btn-outline-secondary ms-2" id="nextBtn">&#10095;</button>
        </div>

        {{-- Botones de acción --}}
        <div class="d-flex gap-3 mb-4">
            <button class="btn btn-success" onclick="toggleForm('disfraz')">+ Añadir Disfraz</button>
            <button class="btn btn-primary" onclick="toggleForm('categoria')">+ Añadir Categoría</button>
        </div>

        {{-- Formulario Disfraz --}}
        <div id="formulario-disfraz" class="card p-4 mb-5 shadow d-none">
            <form method="POST" action="{{ isset($disfraz) ? route('admin.disfraces.update', $disfraz->id) : route('admin.disfraces.store') }}" enctype="multipart/form-data">
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
                            <option value="">Seleccione</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}" @if(isset($disfraz) && $cat->id == $disfraz->categoria_id) selected @endif>{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control">{{ $disfraz->descripcion ?? '' }}</textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Cantidad Total</label>
                        <input type="number" name="cantidad_total" class="form-control" value="{{ $disfraz->cantidad_total ?? '' }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cantidad Disponible</label>
                        <input type="number" name="cantidad_disponible" class="form-control" value="{{ $disfraz->cantidad_disponible ?? '' }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" step="0.01" class="form-control" value="{{ $disfraz->precio ?? '' }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="imagen" class="form-control">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ isset($disfraz) ? 'Actualizar' : 'Guardar' }}</button>
                    <button type="button" class="btn btn-secondary" onclick="closeForms()">Cancelar</button>
                </div>
            </form>
        </div>

        {{-- Formulario Categoría --}}
        <div id="formulario-categoria" class="card p-4 mb-5 shadow d-none">
            <form method="POST" action="{{ route('admin.categorias.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre de la Categoría</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                    <button type="button" class="btn btn-secondary" onclick="closeForms()">Cancelar</button>
                </div>
            </form>
        </div>

        {{-- Cards por categoría --}}
        @foreach ($categorias as $categoria)
            <div class="categoria-section" data-category="{{ $categoria->id }}">
                <h3 class="mt-5">{{ $categoria->nombre }}</h3>
                <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                    @foreach ($disfraces->where('categoria_id', $categoria->id) as $disfrazCard)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                @if($disfrazCard->imagen)
                                    <img src="{{ asset('storage/' . $disfrazCard->imagen) }}" class="card-img-top" alt="{{ $disfrazCard->nombre }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Sin+imagen" class="card-img-top" alt="Sin imagen">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $disfrazCard->nombre }}</h5>
                                    <p class="card-text">{{ $disfrazCard->descripcion ?? 'Sin descripción' }}</p>
                                    <p><strong>Stock:</strong> {{ $disfrazCard->cantidad_disponible }} / {{ $disfrazCard->cantidad_total }}</p>
                                    <p><strong>Precio:</strong> S/. {{ number_format($disfrazCard->precio, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Tabla de disfraces con edición inline --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover">
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
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td contenteditable="true">{{ $d->nombre }}</td>
                            <td>{{ $d->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td contenteditable="true">{{ $d->cantidad_total }}</td>
                            <td contenteditable="true">{{ $d->cantidad_disponible }}</td>
                            <td contenteditable="true">S/. {{ number_format($d->precio, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.disfraces.edit', $d->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.disfraces.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este disfraz?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const carousel = document.getElementById('carouselCategorias');
        document.getElementById('prevBtn').onclick = () => carousel.scrollBy({ left: -150, behavior: 'smooth' });
        document.getElementById('nextBtn').onclick = () => carousel.scrollBy({ left: 150, behavior: 'smooth' });

        const filtroBtns = document.querySelectorAll('.filter-btn');
        const secciones = document.querySelectorAll('.categoria-section');

        filtroBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filtroBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const cat = btn.dataset.category;
                secciones.forEach(sec => {
                    sec.style.display = (cat === 'all' || sec.dataset.category === cat) ? 'block' : 'none';
                });
            });
        });

        function toggleForm(type) {
            closeForms();
            const form = document.getElementById(`formulario-${type}`);
            if (form) form.classList.remove('d-none');
        }

        function closeForms() {
            document.getElementById('formulario-disfraz').classList.add('d-none');
            document.getElementById('formulario-categoria').classList.add('d-none');
        }
    </script>
@endsection
