@extends('layouts.cliente')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle me-3" style="width: 50px; height: 50px;">
                    <i class="bi bi-person-circle text-primary fs-4"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold text-dark">Mi Perfil</h2>
                    <p class="text-muted mb-0">Administra tu información personal</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Perfil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img src="{{ $user->imagen ? asset('storage/' . $user->imagen) . '?t=' . time() : asset('images/default-user.png') }}"
                                 class="rounded-circle shadow-sm border border-2 border-light"
                                 width="120" height="120" alt="Foto de perfil" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <h3 class="fw-bold text-dark mb-3">{{ $user->nombre }} {{ $user->apellido }}</h3>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Correo</small>
                                    <span class="fw-medium">{{ $user->correo }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Teléfono</small>
                                    <span class="fw-medium">{{ $user->telefono ?? 'No registrado' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary px-4 py-2"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#formularioEdicion"
                                aria-expanded="false"
                                aria-controls="formularioEdicion">
                            <i class="bi bi-pencil-square me-2"></i>
                            Editar Perfil
                        </button>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="collapse" id="formularioEdicion">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-gear-fill me-2 text-primary"></i>
                            Editar Información Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('cliente.perfil.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="imagen" class="form-label fw-medium">
                                        <i class="bi bi-image me-2 text-primary"></i>
                                        Cambiar foto de perfil
                                    </label>
                                    <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-medium">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $user->nombre) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-medium">Apellido</label>
                                    <input type="text" name="apellido" class="form-control" required value="{{ old('apellido', $user->apellido) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="correo" class="form-label fw-medium">Correo</label>
                                    <input type="email" name="correo" class="form-control" required value="{{ old('correo', $user->correo) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-medium">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
                                </div>

                                <div class="col-12">
                                    <hr class="my-4">
                                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-lock me-2 text-warning"></i>Seguridad</h6>
                                </div>

                                <div class="col-md-6">
                                    <label for="clave_actual" class="form-label fw-medium">Contraseña Actual *</label>
                                    <input type="password" name="clave_actual" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="clave" class="form-label fw-medium">Nueva Contraseña</label>
                                    <input type="password" name="clave" class="form-control" placeholder="Opcional">
                                </div>

                                <div class="col-md-6">
                                    <label for="clave_confirmation" class="form-label fw-medium">Confirmar Contraseña</label>
                                    <input type="password" name="clave_confirmation" class="form-control" placeholder="Confirma tu nueva contraseña">
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-success px-4 me-3">
                                        <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-toggle="collapse" data-bs-target="#formularioEdicion">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 12px;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endsection