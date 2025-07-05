@extends('layouts.admin')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 fw-bold text-primary">Mi Perfil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow border-0 mb-4">
        <div class="card-body text-center">
            <img src="{{ $admin->foto ? asset('storage/' . $admin->foto) : asset('images/default-user.png') }}"
                 class="rounded-circle shadow mb-3"
                 width="150" height="150" alt="Foto de perfil">
            <h4 class="fw-bold">{{ $admin->nombre }} {{ $admin->apellido }}</h4>
            <p class="mb-1"><strong>Correo:</strong> {{ $admin->correo }}</p>
            <p><strong>Teléfono:</strong> {{ $admin->telefono ?? 'No registrado' }}</p>

            <button class="btn btn-primary mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#formularioEdicion" aria-expanded="false" aria-controls="formularioEdicion">
                <i class="bi bi-pencil-square me-1"></i> Editar Perfil
            </button>
        </div>
    </div>

    <div class="collapse" id="formularioEdicion">
        <div class="card shadow border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.perfil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="foto" class="form-label">Cambiar foto de perfil</label>
                            <input type="file" id="foto" name="foto" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required
                                   value="{{ old('nombre', $admin->nombre) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required
                                   value="{{ old('apellido', $admin->apellido) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" id="correo" name="correo" class="form-control" required
                                   value="{{ old('correo', $admin->correo) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control"
                                   value="{{ old('telefono', $admin->telefono) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="clave_actual" class="form-label">Contraseña actual <span class="text-danger">*</span></label>
                            <input type="password" id="clave_actual" name="clave_actual" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="clave" class="form-label">Nueva Contraseña (opcional)</label>
                            <input type="password" id="clave" name="clave" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="clave_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" id="clave_confirmation" name="clave_confirmation" class="form-control">
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
