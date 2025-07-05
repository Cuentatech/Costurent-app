@extends('layouts.admin')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="bi bi-person-circle text-primary fs-3"></i>
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
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $admin->imagen ? asset('storage/' . $admin->imagen) . '?t=' . time() : asset('images/default-user.png') }}"
                                    class="rounded-circle shadow-sm border border-3 border-white"
                                    width="140" height="140" alt="Foto de perfil"
                                    style="object-fit: cover;">
                                <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2" style="cursor: pointer;" onclick="document.getElementById('imagen').click()">
                                    <i class="bi bi-camera-fill text-white fs-6"></i>
                                </div>
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
                                            <small class="text-muted d-block">Correo Electrónico</small>
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
                        <button class="btn btn-primary px-4 py-2 rounded-pill" 
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
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
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
                                    <label for="foto" class="form-label fw-medium">
                                        <i class="bi bi-image me-2 text-primary"></i>
                                        Cambiar foto de perfil
                                    </label>
                                    <input type="file" 
                                        id="imagen" 
                                        name="imagen"  {{-- ← CAMBIAR esto a "imagen" --}}
                                        class="form-control form-control-lg rounded-pill"
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
                                           class="form-control form-control-lg rounded-pill" 
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
                                           class="form-control form-control-lg rounded-pill" 
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
                                           class="form-control form-control-lg rounded-pill" 
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
                                           class="form-control form-control-lg rounded-pill"
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
                                           class="form-control form-control-lg rounded-pill" 
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
                                           class="form-control form-control-lg rounded-pill"
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
                                           class="form-control form-control-lg rounded-pill"
                                           placeholder="Confirma tu nueva contraseña">
                                </div>

                                <!-- Botones -->
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill me-3">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Guardar Cambios
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-secondary btn-lg px-5 rounded-pill"
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
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.btn {
    transition: all 0.3s ease;
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