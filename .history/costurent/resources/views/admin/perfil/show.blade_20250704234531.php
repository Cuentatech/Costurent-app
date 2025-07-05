@extends('layouts.admin')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 fw-bold text-primary">Mi Perfil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.perfil.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required
                               value="{{ old('nombre', $admin->nombre) }}">
                    </div>

                    <!-- Apellido -->
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" required
                               value="{{ old('apellido', $admin->apellido) }}">
                    </div>

                    <!-- Correo -->
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" class="form-control" required
                               value="{{ old('correo', $admin->correo) }}">
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control"
                               value="{{ old('telefono', $admin->telefono) }}">
                    </div>

                    <!-- Nueva Clave -->
                    <div class="col-md-6">
                        <label for="clave" class="form-label">Nueva Contraseña (opcional)</label>
                        <input type="password" id="clave" name="clave" class="form-control">
                    </div>

                    <!-- Confirmar Clave -->
                    <div class="col-md-6">
                        <label for="clave_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" id="clave_confirmation" name="clave_confirmation" class="form-control">
                    </div>

                    <!-- Botón -->
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
