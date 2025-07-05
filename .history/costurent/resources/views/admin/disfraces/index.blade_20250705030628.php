@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">🎭 Gestión de Disfraces</h1>

    {{-- Carrusel de filtros por categoría --}}
    <div class="d-flex align-items-center mb-4">
        <button class="btn btn-outline-secondary me-2" onclick="scrollCarousel(-300)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="flex-grow-1 overflow-auto" id="category-carousel" style="white-space: nowrap;">
            <button class="btn btn-outline-primary me-2 filter-btn active" data-category="all">Todos</button>
            @foreach ($categorias as $cat)
                <button class="btn btn-outline-primary me-2 filter-btn" data-category="{{ $cat->id }}">{{ $cat->nombre }}</button>
            @endforeach
        </div>
        <button class="btn btn-outline-secondary ms-2" onclick="scrollCarousel(300)">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    {{-- Botones para mostrar formularios --}}
    <div class="mb-4 d-flex gap-2">
        <button class="btn btn-success" onclick="mostrarFormulario('disfraz')">+ Añadir Disfraz</button>
        <button class="btn btn-primary" onclick="mostrarFormulario('categoria')">+ Añadir Categoría</button>
    </div>

    {{-- Formulario Disfraz --}}
    <div id="formulario-disfraz" class="card p-4 mb-4 d-none">
        <form method="POST" action="{{ route('admin.disfraces.store') }}" enctype="multipart/form-data">
            @csrf
            <h5 class="mb-3">Nuevo Disfraz</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control" rows="2"></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Cantidad Total</label>
                    <input type="number" name="cantidad_total" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Cantidad Disponible</label>
                    <input type="number" name="cantidad_disponible" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Precio</label>
                    <input type="number" name="precio" class="form-control" step="0.01" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarFormularios()">Cancelar</button>
            </div>
        </form>
    </div>

    {{-- Formulario Categoría --}}
    <div id="formulario-categoria" class="card p-4 mb-4 d-none">
        <form method="POST" action="{{ route('admin.categorias.store') }}">
            @csrf
            <h5 class="mb-3">Nueva Categoría</h5>
            <div class="mb-3">
                <label>Nombre de la Categoría</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarFormularios()">Cancelar</button>
            </div>
        </form>
    </div>

    {{-- Cards de disfraces --}}
    @foreach ($categorias as $categoria)
        <h4 class="mt-5">{{ $categoria->nombre }}</h4>
        <div class="row mb-4">
            @foreach ($disfraces->where('categoria_id', $categoria->id) as $disfraz)
                <div class="col-md-4 mb-3 costume-item" data-category="{{ $categoria->id }}">
                    <div class="card h-100">
                        <img src="{{ $disfraz->imagen ? asset('storage/' . $disfraz->imagen) : 'https://via.placeholder.com/300x200?text=Sin+imagen' }}"
                            class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $disfraz->nombre }}</h5>
                            <p class="card-text">{{ $disfraz->descripcion ?? 'Sin descripción' }}</p>
                            <span class="badge bg-success">S/. {{ number_format($disfraz->precio, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    {{-- Tabla con edición en línea --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
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
                    <tr id="row-{{ $d->id }}">
                        <td>{{ $d->id }}</td>
                        <td contenteditable="false" id="nombre-{{ $d->id }}">{{ $d->nombre }}</td>
                        <td>{{ $d->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td contenteditable="false" id="total-{{ $d->id }}">{{ $d->cantidad_total }}</td>
                        <td contenteditable="false" id="disp-{{ $d->id }}">{{ $d->cantidad_disponible }}</td>
                        <td contenteditable="false" id="precio-{{ $d->id }}">{{ $d->precio }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editarFila({{ $d->id }})">Editar</button>
                            <button class="btn btn-sm btn-success d-none" id="save-{{ $d->id }}" onclick="guardarFila({{ $d->id }})">Guardar</button>
                            <button class="btn btn-sm btn-secondary d-none" id="cancel-{{ $d->id }}" onclick="cancelarEdicion({{ $d->id }})">Cancelar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Script --}}
<script>
    function scrollCarousel(amount) {
        document.getElementById('category-carousel').scrollBy({ left: amount, behavior: 'smooth' });
    }

    // Mostrar solo un formulario
    function mostrarFormulario(tipo) {
        cerrarFormularios();
        document.getElementById('formulario-' + tipo).classList.remove('d-none');
    }

    function cerrarFormularios() {
        document.getElementById('formulario-disfraz').classList.add('d-none');
        document.getElementById('formulario-categoria').classList.add('d-none');
    }

    // Edición en línea
    let originales = {};
    function editarFila(id) {
        ['nombre', 'total', 'disp', 'precio'].forEach(campo => {
            const celda = document.getElementById(`${campo}-${id}`);
            originales[campo] = celda.innerText;
            celda.contentEditable = true;
            celda.classList.add('table-warning');
        });
        document.getElementById(`save-${id}`).classList.remove('d-none');
        document.getElementById(`cancel-${id}`).classList.remove('d-none');
    }

    function cancelarEdicion(id) {
        ['nombre', 'total', 'disp', 'precio'].forEach(campo => {
            const celda = document.getElementById(`${campo}-${id}`);
            celda.innerText = originales[campo];
            celda.contentEditable = false;
            celda.classList.remove('table-warning');
        });
        document.getElementById(`save-${id}`).classList.add('d-none');
        document.getElementById(`cancel-${id}`).classList.add('d-none');
    }

    function guardarFila(id) {
        const data = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            nombre: document.getElementById(`nombre-${id}`).innerText,
            cantidad_total: document.getElementById(`total-${id}`).innerText,
            cantidad_disponible: document.getElementById(`disp-${id}`).innerText,
            precio: document.getElementById(`precio-${id}`).innerText
        };

        fetch(`/admin/disfraces/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        }).then(response => response.json())
          .then(res => {
              if (res.success) {
                  cancelarEdicion(id);
                  location.reload();
              } else {
                  alert('Error al guardar');
              }
          }).catch(err => {
              console.error(err);
              alert('Error al guardar');
          });
    }

    // Filtro por categoría
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const cat = btn.dataset.category;
            document.querySelectorAll('.costume-item').forEach(card => {
                if (cat === 'all' || card.dataset.category === cat) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
