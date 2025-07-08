@extends('layouts.cliente')

@section('title', 'Mi Perfil')

@section('content')
<div class="dashboard-container">
    {{-- Header --}}
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="dashboard-title">Tu información</h1>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <div class="row justify-content">
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
<div class="dashboard-container">
    {{-- Header --}}
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-text">
                <p class="dashboard-subtitle">Resumen de tu actividad en la plataforma</p>
            </div>
        </div>
    </div>

    {{-- Estadísticas del Cliente --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-success">
            <div class="stat-card-inner">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $alquileresActivos }}</h3>
                    <p class="stat-label">Alquileres Activos</p>
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-warning">
            <div class="stat-card-inner">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $alquileresRetrasados }}</h3>
                    <p class="stat-label">Alquileres Retrasados</p>
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-primary">
            <div class="stat-card-inner">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-bookmark-check-fill"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $reservados }}</h3>
                    <p class="stat-label">Reservas Realizadas</p>
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 40%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Próximos Vencimientos --}}
    <div class="main-dashboard-content mt-4">
        <div class="content-card activity-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-calendar-event-fill me-2"></i>
                    Próximos Vencimientos
                </h2>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    @forelse($proximosVencimientos as $alquiler)
                        <div class="timeline-item">
                            <div class="timeline-marker timeline-marker-warning">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">
                                    {{ $alquiler->disfraz->nombre }} (x{{ $alquiler->cantidad }})
                                </h4>
                                <p class="timeline-time">
                                    Vence en {{ $alquiler->dias_restantes }} día{{ $alquiler->dias_restantes !== 1 ? 's' : '' }}
                                    - {{ \Carbon\Carbon::parse($alquiler->fecha_fin)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h3>Sin vencimientos próximos</h3>
                            <p>No tienes alquileres que venzan pronto</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
</div>

@push('styles')
<style>
:root {
    --primary-color: #6366f1;
    --primary-light: #818cf8;
    --primary-dark: #4f46e5;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #3b82f6;
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
    --border-radius: 16px;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* IMPORTANTE: No sobrescribir el body */
.dashboard-container {
    width: 100%;
    max-width: none;
    margin: 0;
    padding: 0;
    min-height: auto;
}

/* Header */
.dashboard-header {
    padding: 1.5rem 0;
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.dashboard-subtitle {
    color: var(--gray-600);
    font-size: 1.1rem;
    margin: 0;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    animation: fadeInUp 0.6s ease-out;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
}

.stat-card-success::before {
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.stat-card-warning::before {
    background: linear-gradient(90deg, var(--warning-color), #fbbf24);
}

.stat-card-info::before {
    background: linear-gradient(90deg, var(--info-color), #60a5fa);
}

.stat-card-inner {
    padding: 1.5rem;
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
}

.stat-card-success .stat-icon {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
}

.stat-card-warning .stat-icon {
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
}

.stat-card-info .stat-icon {
    background: linear-gradient(135deg, var(--info-color), #60a5fa);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--gray-600);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.stat-progress {
    height: 6px;
    background: var(--gray-200);
    border-radius: 3px;
    overflow: hidden;
}

.stat-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    border-radius: 3px;
    transition: width 1s ease-out;
}

.stat-card-success .stat-progress-bar {
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.stat-card-warning .stat-progress-bar {
    background: linear-gradient(90deg, var(--warning-color), #fbbf24);
}

.stat-card-info .stat-progress-bar {
    background: linear-gradient(90deg, var(--info-color), #60a5fa);
}

/* Main Content */
.main-dashboard-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.content-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--gray-900);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-ghost {
    background: none;
    border: none;
    padding: 0.5rem;
    border-radius: 8px;
    color: var(--gray-500);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-ghost:hover {
    background: var(--gray-100);
    color: var(--gray-700);
}

.card-body {
    padding: 1.5rem;
}

/* Activity Timeline */
.activity-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    width: 2px;
    height: calc(100% + 0.5rem);
    background: var(--gray-200);
}

.timeline-marker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.timeline-marker-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
}

.timeline-marker-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
}

.timeline-marker-warning {
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
}

.timeline-marker-danger {
    background: linear-gradient(135deg, var(--danger-color), #f87171);
}

.timeline-content {
    flex: 1;
    padding-top: 0.25rem;
}

.timeline-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
}

.timeline-time {
    font-size: 0.8rem;
    color: var(--gray-500);
    margin: 0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    font-size: 3rem;
    color: var(--gray-400);
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.2rem;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--gray-500);
    margin: 0;
}

/* Quick Actions */
.quick-actions-card {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    margin-bottom: 2rem;
    overflow: hidden;
}

.quick-actions-header {
    background: var(--gray-900);
    color: white;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.quick-actions-header i {
    font-size: 1.5rem;
}

.quick-actions-header h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.quick-actions-body {
    padding: 2rem;
}

.quick-actions-grid {
    display: grid;
    gap: 1rem;
}

.quick-action-item {
    position: relative;
}

.quick-action-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: 16px;
    text-decoration: none;
    color: white;
    border: 2px solid transparent;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.quick-action-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
}

.quick-action-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.quick-action-warning {
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
}

.quick-action-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s;
}

.quick-action-link:hover::before {
    opacity: 1;
}

.quick-action-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.action-text {
    flex: 1;
    font-size: 1rem;
    font-weight: 600;
    color: white;
}

.action-arrow {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .main-dashboard-content {
        grid-template-columns: 1fr;
    }
    
    .dashboard-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .dashboard-header {
        padding: 1rem 0;
    }
    
    .stat-card-inner {
        padding: 1.25rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress bar animation
    const progressBars = document.querySelectorAll('.stat-progress-bar');
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const width = entry.target.style.width;
                entry.target.style.width = '0%';
                setTimeout(() => {
                    entry.target.style.width = width;
                }, 500);
                progressObserver.unobserve(entry.target);
            }
        });
    });
    
    progressBars.forEach(bar => progressObserver.observe(bar));
});
</script>
@endpush
@endsection