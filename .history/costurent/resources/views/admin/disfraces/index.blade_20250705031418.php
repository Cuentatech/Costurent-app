{{-- resources/views/admin/disfraces/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestión de Disfraces')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Disfraces</h1>

    {{-- Buscador --}}
    <form method="GET" action="{{ route('admin.disfraces.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Buscar por nombre o categoría" autocomplete="off">
            <button class="btn btn-outline-secondary">Buscar</button>
            <a href="{{ route('admin.disfraces.index') }}" class="btn btn-outline-danger">Limpiar</a>
        </div>
    </form>

    {{-- Botones +nciso --}}
    <div class="mb-4 d-flex gap-2">
        <button type="button" class="btn btn-success" onclick="toggleForm('disfraz')">+ Añadir Disfraz</button>
        <button type="button" class="btn btn-primary" onclick="toggleForm('categoria')">+ Añadir Categoría</button>
    </div>

    {{-- Form Disfraz --}}
    <div id="form-disfraz" class="card p-4 mb-4 shadow d-none">
        <form method="POST" action="{{ route('admin.disfraces.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Campos --}}
            <div class="row">
                <x-input-field name="nombre" label="Nombre" required />
                <x-select-field name="categoria_id" label="Categoría" :options="$categorias" option-label="nombre" option-value="id" required />
            </div>
            <div class="row">
                <x-input-field name="cantidad_total" label="Cantidad Total" type="number" required />
                <x-input-field name="cantidad_disponible" label="Disponible" type="number" required />
                <x-input-field name="precio" label="Precio" type="number" step="0.01" required />
            </div>
            <x-textarea-field name="descripcion" label="Descripción" />
            <x-file-field name="imagen" label="Imagen" />
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="toggleForm()">Cancelar</button>
            </div>
        </form>
    </div>

    {{-- Form Categoría --}}
    <div id="form-categoria" class="card p-4 mb-4 shadow d-none">
        <form method="POST" action="{{ route('admin.categorias.store') }}">
            @csrf
            <x-input-field name="nombre" label="Nombre de la Categoría" required />
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                <button type="button" class="btn btn-secondary" onclick="toggleForm()">Cancelar</button>
            </div>
        </form>
    </div>

    {{-- Carrusel filtrable --}}
    @foreach($categorias as $categoria)
        <h3 class="mt-5">{{ $categoria->nombre }}</h3>
        <div class="position-relative mb-4">
            <button class="btn btn-light position-absolute start-0 top-50 translate-middle-y"
                    onclick="scrollCarousel('carr-{{ $categoria->id }}', -1)">‹</button>

            <div id="carr-{{ $categoria->id }}" class="d-flex overflow-auto gap-3 px-3">
                @foreach($disfraces->filter(fn($d) => $d->categoria_id == $categoria->id) as $d)
                    <div class="card" style="min-width: 250px; max-width: 250px;">
                        <img src="{{ $d->imagen ? asset('storage/'.$d->imagen) : 'https://via.placeholder.com/250x180' }}"
                             class="card-img-top" style="height:180px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $d->nombre }}</h5>
                            <p class="card-text">{{ Str::limit($d->descripcion, 80) }}</p>
                            <p class="fw-bold">S/. {{ number_format($d->precio,2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="btn btn-light position-absolute end-0 top-50 translate-middle-y"
                    onclick="scrollCarousel('carr-{{ $categoria->id }}', 1)">›</button>
        </div>
    @endforeach

    {{-- Tabla editable --}}
    <div class="table-responsive mb-5 shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Nombre</th><th>Categoría</th><th>Total</th><th>Disponibles</th><th>Precio</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $editId = request('editar'); @endphp
                @foreach($disfraces as $d)
                    @if($editId == $d->id)
                        <form action="{{ route('admin.disfraces.update', $d->id) }}" method="POST">
                            @csrf @method('PUT')
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td><input name="nombre" class="form-control" value="{{ $d->nombre }}"></td>
                                <td>
                                    <select name="categoria_id" class="form-select">
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}" @selected($cat->id==$d->categoria_id)>{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="cantidad_total" value="{{ $d->cantidad_total }}" class="form-control"></td>
                                <td><input type="number" name="cantidad_disponible" value="{{ $d->cantidad_disponible }}" class="form-control"></td>
                                <td><input type="number" step="0.01" name="precio" value="{{ $d->precio }}" class="form-control"></td>
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
                            <td>{{ $d->categoria->nombre }}</td>
                            <td>{{ $d->cantidad_total }}</td>
                            <td>{{ $d->cantidad_disponible }}</td>
                            <td>S/. {{ number_format($d->precio,2) }}</td>
                            <td>
                                <a href="{{ route('admin.disfraces.index', ['editar'=>$d->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.disfraces.destroy', $d->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
 function toggleForm(which=null) {
    ['disfraz','categoria'].forEach(id => {
        document.getElementById('form-'+id).classList.toggle('d-none', which !== id);
    });
 }
 
 function scrollCarousel(id, dir) {
   document.getElementById(id).scrollBy({ left: dir*300, behavior: 'smooth' });
 }
</script>
@endpush
@endsection
