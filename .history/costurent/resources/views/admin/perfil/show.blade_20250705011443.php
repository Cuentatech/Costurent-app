@extends('layouts.admin')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header con gradiente -->
            <div class="profile-header mb-5">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="header-icon-wrapper">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ms-4">
                            <h1 class="header-title mb-0">Mi Perfil</h1>
                            <p class="header-subtitle mb-0">Gestiona tu información personal y configuración</p>
                        </div>
                    </div>
                    <div class="header-decoration">
                        <div class="decoration-circle circle-1"></div>
                        <div class="decoration-circle circle-2"></div>
                        <div class="decoration-circle circle-3"></div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="success-alert mb-4">
                    <div class="alert-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="alert-content">
                        <h6>¡Éxito!</h6>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Perfil Card Principal -->
            <div class="profile-card mb-4">
                <div class="profile-card-bg"></div>
                <div class="profile-card-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 text-center mb-4 mb-lg-0">
                            <div class="profile-image-container">
                                <img src="{{ $admin->foto ? asset('storage/' . $admin->foto) : asset('images/default-user.png') }}"
                                     class="profile-image"
                                     alt="Foto de perfil">
                                <div class="image-overlay">
                                    <i class="bi bi-camera-fill"></i>
                                </div>
                                <div class="image-border"></div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="profile-info">
                                <h2 class="profile-name">{{ $admin->nombre }} {{ $admin->apellido }}</h2>
                                <div class="profile-details">
                                    <div class="detail-item">
                                        <div class="detail-icon email">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <div class="detail-content">
                                            <span class="detail-label">Correo Electrónico</span>
                                            <span class="detail-value">{{ $admin->correo }}</span>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-icon phone">
                                            <i class="bi bi-telephone-fill"></i>
                                        </div>
                                        <div class="detail-content">
                                            <span class="detail-label">Teléfono</span>
                                            <span class="detail-value">{{ $admin->telefono ?? 'No registrado' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button class="edit-btn" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#formularioEdicion" 
                                aria-expanded="false" 
                                aria-controls="formularioEdicion">
                            <span class="btn-content">
                                <i class="bi bi-pencil-square"></i>
                                <span>Editar Perfil</span>
                            </span>
                            <div class="btn-bg"></div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Formulario de edición -->
            <div class="collapse" id="formularioEdicion">
                <div class="edit-form-card">
                    <div class="form-header">
                        <div class="form-header-icon">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                        <div class="form-header-content">
                            <h3>Editar Información Personal</h3>
                            <p>Actualiza tus datos personales y configuración de seguridad</p>
                        </div>
                    </div>
                    
                    <div class="form-body">
                        <form method="POST" action="{{ route('admin.perfil.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-sections">
                                <!-- Sección: Foto de perfil -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="bi bi-image"></i>
                                        <span>Foto de Perfil</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto" class="form-label">
                                            Cambiar foto de perfil
                                        </label>
                                        <div class="file-input-wrapper">
                                            <input type="file" 
                                                   id="foto" 
                                                   name="foto" 
                                                   class="file-input"
                                                   accept="image/*">
                                            <div class="file-input-display">
                                                <i class="bi bi-cloud-upload"></i>
                                                <span>Arrastra una imagen aquí o haz clic para seleccionar</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección: Información personal -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="bi bi-person"></i>
                                        <span>Información Personal</span>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nombre" class="form-label">
                                                    <i class="bi bi-person"></i>
                                                    Nombre
                                                </label>
                                                <input type="text" 
                                                       id="nombre" 
                                                       name="nombre" 
                                                       class="form-control" 
                                                       required
                                                       value="{{ old('nombre', $admin->nombre) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apellido" class="form-label">
                                                    <i class="bi bi-person"></i>
                                                    Apellido
                                                </label>
                                                <input type="text" 
                                                       id="apellido" 
                                                       name="apellido" 
                                                       class="form-control" 
                                                       required
                                                       value="{{ old('apellido', $admin->apellido) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="correo" class="form-label">
                                                    <i class="bi bi-envelope"></i>
                                                    Correo Electrónico
                                                </label>
                                                <input type="email" 
                                                       id="correo" 
                                                       name="correo" 
                                                       class="form-control" 
                                                       required
                                                       value="{{ old('correo', $admin->correo) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telefono" class="form-label">
                                                    <i class="bi bi-telephone"></i>
                                                    Teléfono
                                                </label>
                                                <input type="text" 
                                                       id="telefono" 
                                                       name="telefono" 
                                                       class="form-control"
                                                       value="{{ old('telefono', $admin->telefono) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección: Seguridad -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="bi bi-shield-lock"></i>
                                        <span>Seguridad</span>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="clave_actual" class="form-label">
                                                    <i class="bi bi-lock"></i>
                                                    Contraseña actual <span class="required">*</span>
                                                </label>
                                                <input type="password" 
                                                       id="clave_actual" 
                                                       name="clave_actual" 
                                                       class="form-control" 
                                                       required
                                                       placeholder="Ingresa tu contraseña actual">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="clave" class="form-label">
                                                    <i class="bi bi-key"></i>
                                                    Nueva Contraseña
                                                </label>
                                                <input type="password" 
                                                       id="clave" 
                                                       name="clave" 
                                                       class="form-control"
                                                       placeholder="Solo si deseas cambiarla">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="clave_confirmation" class="form-label">
                                                    <i class="bi bi-key"></i>
                                                    Confirmar Contraseña
                                                </label>
                                                <input type="password" 
                                                       id="clave_confirmation" 
                                                       name="clave_confirmation" 
                                                       class="form-control"
                                                       placeholder="Confirma tu nueva contraseña">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="form-actions">
                                    <button type="submit" class="action-btn primary">
                                        <span class="btn-content">
                                            <i class="bi bi-check-circle"></i>
                                            <span>Guardar Cambios</span>
                                        </span>
                                        <div class="btn-bg"></div>
                                    </button>
                                    <button type="button" 
                                            class="action-btn secondary"
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#formularioEdicion">
                                        <span class="btn-content">
                                            <i class="bi bi-x-circle"></i>
                                            <span>Cancelar</span>
                                        </span>
                                        <div class="btn-bg"></div>
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
/* Variables CSS */
:root {
    --primary-color: #6366f1;
    --primary-light: #a5b4fc;
    --primary-dark: #4338ca;
    --secondary-color: #10b981;
    --secondary-light: #6ee7b7;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --dark-color: #1f2937;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --border-radius: 16px;
    --border-radius-lg: 24px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Header */
.profile-header {
    position: relative;
    padding: 2rem 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    border-radius: var(--border-radius-lg);
    color: white;
    overflow: hidden;
}

.header-icon-wrapper {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.header-icon-wrapper i {
    font-size: 2.5rem;
    color: white;
}

.header-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 300;
}

.header-decoration {
    position: relative;
    width: 120px;
    height: 120px;
}

.decoration-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(5px);
}

.circle-1 {
    width: 60px;
    height: 60px;
    top: 0;
    right: 0;
    animation: float 6s ease-in-out infinite;
}

.circle-2 {
    width: 40px;
    height: 40px;
    bottom: 20px;
    right: 30px;
    animation: float 4s ease-in-out infinite reverse;
}

.circle-3 {
    width: 30px;
    height: 30px;
    top: 30px;
    right: 60px;
    animation: float 5s ease-in-out infinite;
}

/* Alerts */
.success-alert {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-light) 100%);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    color: white;
    box-shadow: var(--shadow-lg);
    animation: slideInDown 0.5s ease;
}

.alert-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.alert-icon i {
    font-size: 1.5rem;
}

.alert-content h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
}

.alert-content p {
    margin: 0;
    opacity: 0.9;
}

/* Profile Card */
.profile-card {
    position: relative;
    background: white;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    transition: var(--transition);
}

.profile-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 32px 64px -12px rgba(0, 0, 0, 0.25);
}

.profile-card-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    opacity: 0.1;
}

.profile-card-content {
    position: relative;
    padding: 2.5rem;
}

.profile-image-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.profile-image {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    border: 6px solid white;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
}

.image-overlay {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    cursor: pointer;
}

.image-overlay:hover {
    background: var(--primary-dark);
    transform: scale(1.1);
}

.image-border {
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: var(--transition);
    z-index: -1;
}

.profile-image-container:hover .image-border {
    opacity: 1;
}

.profile-name {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 2rem;
    text-align: center;
}

@media (min-width: 992px) {
    .profile-name {
        text-align: left;
    }
}

.profile-details {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.detail-item:hover {
    background: var(--gray-100);
    transform: translateX(4px);
}

.detail-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
}

.detail-icon.email {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
}

.detail-icon.phone {
    background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
}

.detail-content {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 0.875rem;
    color: var(--gray-500);
    font-weight: 500;
}

.detail-value {
    font-size: 1rem;
    color: var(--gray-900);
    font-weight: 600;
}

/* Edit Button */
.edit-btn {
    position: relative;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    overflow: hidden;
    border-radius: 50px;
    transition: var(--transition);
}

.edit-btn .btn-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    color: white;
    font-weight: 600;
    font-size: 1rem;
}

.edit-btn .btn-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    transition: var(--transition);
}

.edit-btn:hover .btn-bg {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
    transform: scale(1.05);
}

.edit-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Form Card */
.edit-form-card {
    background: white;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    animation: slideInUp 0.5s ease;
}

.form-header {
    background: linear-gradient(135deg, var(--gray-900), var(--gray-700));
    color: white;
    padding: 2rem;
    display: flex;
    align-items: center;
}

.form-header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.5rem;
}

.form-header-icon i {
    font-size: 1.5rem;
}

.form-header-content h3 {
    margin: 0 0 0.5rem 0;
    font-weight: 700;
}

.form-header-content p {
    margin: 0;
    opacity: 0.8;
}

.form-body {
    padding: 2.5rem;
}

.form-sections {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.form-section {
    border: 1px solid var(--gray-200);
    border-radius: var(--border-radius);
    padding: 2rem;
    background: var(--gray-50);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary-color);
}

.section-header i {
    font-size: 1.25rem;
    color: var(--primary-color);
    margin-right: 0.75rem;
}

.section-header span {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-900);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--gray-700);
}

.form-label i {
    margin-right: 0.5rem;
    color: var(--primary-color);
}

.required {
    color: var(--danger-color);
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.form-control::placeholder {
    color: var(--gray-400);
}

/* File Input */
.file-input-wrapper {
    position: relative;
    border: 2px dashed var(--gray-300);
    border-radius: var(--border-radius);
    padding: 2rem;
    text-align: center;
    transition: var(--transition);
    cursor: pointer;
}

.file-input-wrapper:hover {
    border-color: var(--primary-color);
    background: var(--gray-50);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-input-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.file-input-display i {
    font-size: 2rem;
    color: var(--primary-color);
}

.file-input-display span {
    color: var(--gray-600);
    font-weight: 500;
}

/* Action Buttons */
.form-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.action-btn {
    position: relative;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    overflow: hidden;
    border-radius: 50px;
    transition: var(--transition);
    min-width: 180px;
}

.action-btn .btn-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    color: white;
    font-weight: 600;
    font-size: 1rem;
}

.action-btn .btn-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transition: var(--transition);
}

.action-btn.primary .btn-bg {
    background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
}

.action-btn.secondary .btn-bg {
    background: linear-gradient(135deg, var(--gray-600), var(--gray-500));
}

.action-btn:hover .btn-bg {
    transform: scale(1.05);
}

.action-btn.primary:hover .btn-bg {
    background: linear-gradient(135deg, var(--secondary-light), var(--secondary-color));
}

.action-btn.secondary:hover .btn-bg {
    background: linear-gradient(135deg, var(--gray-500), var(--gray-600));
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Animations */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-title {
        font-size: 2rem;
    }
    
    .profile-card-content {
        padding: 1.5rem;
    }
    
    .profile-image {
        width: 120px;
        height: 120px;
    }
    
    .profile-name {
        font-size: 1.5rem;
    }
    
    .form-body {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .action-btn {
        width: 100%;
        max-width: 300px;
    }
}

@media (max-width: 576px) {
    .profile-header {
        padding: 1.5rem;
    }
    
    .header-icon-wrapper {
        width: 60px;
        height: 60px;
    }
    
    .header-icon-wrapper i {
        font-size: 2rem