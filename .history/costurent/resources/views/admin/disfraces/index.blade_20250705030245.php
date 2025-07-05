@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Disfraces</h1>

    {{-- Carrusel de Categorías --}}
    <div class="d-flex align-items-center mb-3">
        <button class="btn btn-outline-secondary me-2" onclick="scrollCarousel(-200)">&larr;</button>
        <div id="carousel-categorias" class="flex-grow-1 overflow-auto d-flex gap-2">
            <button class="btn btn-outline-dark active" onclick="filtrarCategoria('all')">Todos</button>
            @foreach ($categorias as $categoria)
                <button class="btn btn-outline-dark" onclick="filtrarCategoria('{{ $categoria->id }}')">{{ $categoria->nombre }}</button>
            @endforeach
        </div>
        <button class="btn btn-outline-secondary ms-2" onclick="scrollCarousel(200)">&rarr;</button>
    </div>

    {{-- Botones para mostrar formularios --}}
    <div class="d-flex gap-3 mb-4">
        <button class="btn btn-success" onclick="mostrarFormulario('disfraz')">+ Añadir Disfraz</button>
        <button class="btn btn-primary" onclick="mostrarFormulario('categoria')">+ Añadir Categoría</button>
    </div>

    {{-- Formulario Disfraz --}}
    <div id="formulario-disfraz" class="card p-4 mb-4 d-none">
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
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>

    {{-- Formulario Categoría --}}
    <div id="formulario-categoria" class="card p-4 mb-4 d-none">
        <form method="POST" action="{{ route('admin.categorias.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nombre de la Categoría</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Categoría</button>
        </form>
    </div>

    {{-- Cards por categoría --}}
    @foreach ($categorias as $categoria)
        <div class="categoria-seccion mb-4" data-cat="{{ $categoria->id }}">
            <h3>{{ $categoria->nombre }}</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($disfraces->where('categoria_id', $categoria->id) as $disfraz)
                    <div class="col">
                        <div class="card h-100">
                            @if($disfraz->imagen)
                                <img src="{{ asset('storage/' . $disfraz->imagen) }}" class="card-img-top" alt="...">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $disfraz->nombre }}</h5>
                                <p>{{ $disfraz->descripcion }}</p>
                                <p><strong>Precio:</strong> S/. {{ number_format($disfraz->precio, 2) }}</p>
                                <p><strong>Stock:</strong> {{ $disfraz->cantidad_disponible }}/{{ $disfraz->cantidad_total }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- Tabla de disfraces --}}
    <div class="table-responsive">
        <table class="table table-bordered tabla-disfraz">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Total</th>
                    <th>Disponible</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disfraces as $d)
                    <tr data-cat="{{ $d->categoria_id }}" data-id="{{ $d->id }}">
                        <td>{{ $d->id }}</td>
                        <td contenteditable class="editable" data-field="nombre">{{ $d->nombre }}</td>
                        <td>{{ $d->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td contenteditable class="editable" data-field="cantidad_total">{{ $d->cantidad_total }}</td>
                        <td contenteditable class="editable" data-field="cantidad_disponible">{{ $d->cantidad_disponible }}</td>
                        <td contenteditable class="editable" data-field="precio">{{ $d->precio }}</td>
                        <td><button onclick="guardarEdicion(this)" class="btn btn-sm btn-success">Guardar</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function scrollCarousel(value) {
        const carousel = document.getElementById('carousel-categorias');
        carousel.scrollBy({ left: value, behavior: 'smooth' });
    }

    function filtrarCategoria(catId) {
        document.querySelectorAll('#carousel-categorias button').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');

        document.querySelectorAll('.categoria-seccion').forEach(div => {
            div.style.display = (catId === 'all' || div.dataset.cat === catId) ? 'block' : 'none';
        });

        document.querySelectorAll('.tabla-disfraz tbody tr').forEach(row => {
            row.style.display = (catId === 'all' || row.dataset.cat === catId) ? '' : 'none';
        });
    }

    function mostrarFormulario(tipo) {
        const formDisfraz = document.getElementById('formulario-disfraz');
        const formCategoria = document.getElementById('formulario-categoria');

        if (tipo === 'disfraz') {
            formCategoria.classList.add('d-none');
            formDisfraz.classList.toggle('d-none');
        } else if (tipo === 'categoria') {
            formDisfraz.classList.add('d-none');
            formCategoria.classList.toggle('d-none');
        }
    }

    function guardarEdicion(btn) {
        const row = btn.closest('tr');
        const id = row.dataset.id;
        const data = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
        };

        row.querySelectorAll('.editable').forEach(el => {
            const campo = el.dataset.field;
            data[campo] = el.innerText.trim();
        });

        fetch(`/admin/disfraces/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(resp => resp.json())
        .then(res => {
            if (res.success) {
                alert('Cambios guardados');
            } else {
                alert('Error al guardar');
            }
        });
    }
</script>
@endsection
