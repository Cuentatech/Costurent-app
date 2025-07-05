@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Disfraces</h1>

    {{-- Botones para alternar formularios --}}
    <div class="d-flex gap-3 mb-4">
        <button class="btn btn-success" onclick="mostrarFormulario('disfraz')">+ Añadir Disfraz</button>
        <button class="btn btn-primary" onclick="mostrarFormulario('categoria')">+ Añadir Categoría</button>
    </div>

    {{-- Formulario Disfraz --}}
    <div id="formulario-disfraz" class="card p-4 mb-5 shadow d-none">
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

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="ocultarFormularios()">Cancelar</button>
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
                <button type="button" class="btn btn-secondary" onclick="ocultarFormularios()">Cancelar</button>
            </div>
        </form>
    </div>

    {{-- Carruseles por Categoría --}}
    @foreach ($categorias as $categoria)
        <h3 class="mt-5">{{ $categoria->nombre }}</h3>
        <div class="position-relative">
            <button class="carousel-control-prev btn btn-light shadow" style="top: 45%; position: absolute; z-index: 1;" onclick="scrollCarrusel('{{ $categoria->id }}', -1)">
                ‹
            </button>

            <div id="carousel-{{ $categoria->id }}" class="d-flex overflow-auto gap-3 mb-4 px-2" style="scroll-behavior: smooth;">
                @foreach ($disfraces->where('categoria_id', $categoria->id) as $disfrazCard)
                    <div class="card shadow-sm" style="min-width: 250px; max-width: 250px;">
                        @if($disfrazCard->imagen)
                            <img src="{{ asset('storage/' . $disfrazCard->imagen) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/250x180?text=Sin+imagen" class="card-img-top">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $disfrazCard->nombre }}</h5>
                            <p class="card-text">{{ $disfrazCard->descripcion ?? 'Sin descripción' }}</p>
                            <p class="text-muted mb-0"><strong>Precio:</strong> S/. {{ number_format($disfrazCard->precio, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-next btn btn-light shadow" style="top: 45%; right: 0; position: absolute; z-index: 1;" onclick="scrollCarrusel('{{ $categoria->id }}', 1)">
                ›
            </button>
        </div>
    @endforeach

    {{-- Tabla de disfraces --}}
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover align-middle">
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
                @php $editarId = request()->query('editar'); @endphp
                @foreach ($disfraces as $d)
                    @if($editarId == $d->id)
                        <form action="{{ route('admin.disfraces.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td><input type="text" name="nombre" class="form-control" value="{{ $d->nombre }}"></td>
                                <td>
                                    <select name="categoria_id" class="form-select">
                                        @foreach ($categorias as $cat)
                                            <option value="{{ $cat->id }}" @selected($cat->id == $d->categoria_id)>{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="cantidad_total" class="form-control" value="{{ $d->cantidad_total }}"></td>
                                <td><input type="number" name="cantidad_disponible" class="form-control" value="{{ $d->cantidad_disponible }}"></td>
                                <td><input type="number" step="0.01" name="precio" class="form-control" value="{{ $d->precio }}"></td>
                                <td>
                                    <button class="btn btn-sm btn-success">Guardar</button>
                                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-sm btn-secondary">Cancelar</a>
                                </td>
                            </tr>
                        </form>
                    @else
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->nombre }}</td>
                            <td>{{ $d->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td>{{ $d->cantidad_total }}</td>
                            <td>{{ $d->cantidad_disponible }}</td>
                            <td>S/. {{ number_format($d->precio, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.disfraces.index', ['editar' => $d->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.disfraces.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este disfraz?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Scripts --}}
@push('scripts')
<script>
    function mostrarFormulario(tipo) {
        document.getElementById('formulario-disfraz').classList.add('d-none');
        document.getElementById('formulario-categoria').classList.add('d-none');
        document.getElementById(`formulario-${tipo}`).classList.remove('d-none');
    }

    function ocultarFormularios() {
        document.getElementById('formulario-disfraz').classList.add('d-none');
        document.getElementById('formulario-categoria').classList.add('d-none');
    }

    function scrollCarrusel(id, direction) {
        const carrusel = document.getElementById('carousel-' + id);
        const scrollAmount = 300;
        carrusel.scrollBy({ left: scrollAmount * direction, behavior: 'smooth' });
    }
</script>
@endpush
@endsection
