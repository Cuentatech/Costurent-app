@extends('layouts.admin')

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

            <!-- Perfil Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $admin->imagen ? asset('storage/' . $admin->imagen) . '?t=' . time() : asset('images/default-user.png') }}"
                                    class="rounded-circle shadow-sm border border-2 border-light"
                                    width="120" height="120" alt="Foto de perfil"
                                    style="object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3 class="fw-bold text-dark mb-3">{{ $admin->nombre }} {{ $admin->apellido }}</h3>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-envelope-fill text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Correo</small>
                                            <span class="fw-medium">{{ $admin->correo }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-telephone-fill text-success"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Teléfono</small>
                                            <span class="fw-medium">{{ $admin->telefono ?? 'No registrado' }}</span>
                                        </div>
                                    </div>
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

            <!-- Formulario de edición -->
            <div class="collapse" id="formularioEdicion">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-gear-fill me-2 text-primary"></i>
                            Editar Información Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.perfil.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Foto de perfil -->
                                <div class="col-12">
                                    <label for="imagen" class="form-label fw-medium">
                                        <i class="bi bi-image me-2 text-primary"></i>
                                        Cambiar foto de perfil
                                    </label>
                                    <input type="file" 
                                        id="imagen" 
                                        name="imagen"
                                        class="form-control"
                                        accept="image/*">
                                </div>

                                <!-- Información personal -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-medium">
                                        <i class="bi bi-person me-2 text-primary"></i>
                                        Nombre
                                    </label>
                                    <input type="text" 
                                           id="nombre" 
                                           name="nombre" 
                                           class="form-control" 
                                           required
                                           value="{{ old('nombre', $admin->nombre) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-medium">
                                        <i class="bi bi-person me-2 text-primary"></i>
                                        Apellido
                                    </label>
                                    <input type="text" 
                                           id="apellido" 
                                           name="apellido" 
                                           class="form-control" 
                                           required
                                           value="{{ old('apellido', $admin->apellido) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="correo" class="form-label fw-medium">
                                        <i class="bi bi-envelope me-2 text-primary"></i>
                                        Correo Electrónico
                                    </label>
                                    <input type="email" 
                                           id="correo" 
                                           name="correo" 
                                           class="form-control" 
                                           required
                                           value="{{ old('correo', $admin->correo) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-medium">
                                        <i class="bi bi-telephone me-2 text-success"></i>
                                        Teléfono
                                    </label>
                                    <input type="text" 
                                           id="telefono" 
                                           name="telefono" 
                                           class="form-control"
                                           value="{{ old('telefono', $admin->telefono) }}">
                                </div>

                                <!-- Seguridad -->
                                <div class="col-12">
                                    <hr class="my-4">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="bi bi-shield-lock me-2 text-warning"></i>
                                        Seguridad
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <label for="clave_actual" class="form-label fw-medium">
                                        <i class="bi bi-lock me-2 text-warning"></i>
                                        Contraseña actual <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           id="clave_actual" 
                                           name="clave_actual" 
                                           class="form-control" 
                                           required
                                           placeholder="Ingresa tu contraseña actual">
                                </div>

                                <div class="col-md-6">
                                    <label for="clave" class="form-label fw-medium">
                                        <i class="bi bi-key me-2 text-warning"></i>
                                        Nueva Contraseña
                                    </label>
                                    <input type="password" 
                                           id="clave" 
                                           name="clave" 
                                           class="form-control"
                                           placeholder="Opcional - Solo si deseas cambiarla">
                                </div>

                                <div class="col-md-6">
                                    <label for="clave_confirmation" class="form-label fw-medium">
                                        <i class="bi bi-key me-2 text-warning"></i>
                                        Confirmar Contraseña
                                    </label>
                                    <input type="password" 
                                           id="clave_confirmation" 
                                           name="clave_confirmation" 
                                           class="form-control"
                                           placeholder="Confirma tu nueva contraseña">
                                </div>

                                <!-- Botones -->
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-success px-4 me-3">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Guardar Cambios
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-secondary px-4"
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#formularioEdicion">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Cancelar
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

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
}

.btn {
    transition: all 0.2s ease;
    border-radius: 8px;
}

.btn:hover {
    transform: translateY(-1px);
}

.alert {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection