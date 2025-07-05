@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="dashboard-container">
    {{-- Header Principal --}}
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="dashboard-title">Panel de Administración</h1>
                <p class="dashboard-subtitle">Gestiona tu plataforma desde aquí</p>
            </div>
        </div>
    </div>

    {{-- Tarjetas de Estadísticas --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-inner">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $totalClientes }}</h3>
                    <p class="stat-label">Total de Clientes</p>
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

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
    </div>

    {{-- Contenido Principal --}}
    <div class="main-content">
        {{-- Actividad Reciente --}}
        <div class="content-card activity-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-activity"></i>
                    Actividad Reciente
                </h2>
                <div class="card-actions">
                    <button class="btn-ghost">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    @forelse($actividades as $actividad)
                        <div class="timeline-item">
                            <div class="timeline-marker timeline-marker-{{ $actividad['color'] }}">
                                <i class="bi {{ $actividad['icono'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">{{ $actividad['mensaje'] }}</h4>
                                <p class="timeline-time">{{ $actividad['fecha']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h3>No hay actividad reciente</h3>
                            <p>Cuando tengas actividad en tu plataforma, aparecerá aquí</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- Acciones Rápidas --}}
        <div class="quick-actions-card">
            <div class="quick-actions-header">
                <i class="bi bi-lightning-fill"></i>
                <h5>Acciones Rápidas</h5>
            </div>
            <div class="quick-actions-body">
                <div class="quick-actions-grid">
                    {{-- Nuevo Cliente --}}
                    <div class="quick-action-item">
                        <a href="{{ route('admin.clientes.index') }}" class="quick-action-link primary">
                            <div class="action-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="action-text">Nuevo Cliente</div>
                            <div class="action-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>
                    </div>

                    {{-- Crear Alquiler --}}
                    <div class="quick-action-item">
                        <a href="{{ route('admin.alquileres.index') }}" class="quick-action-link success">
                            <div class="action-icon">
                                <i class="bi bi-plus-square"></i>
                            </div>
                            <div class="action-text">Crear Alquiler</div>
                            <div class="action-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>
                    </div>

                    {{-- Agregar Disfraz --}}
                    <div class="quick-action-item">
                        <a href="{{ route('admin.disfraces.index') }}" class="quick-action-link warning">
                            <div class="action-icon">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                            <div class="action-text">Agregar Disfraz</div>
                            <div class="action-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    color: var(--gray-800);
}

.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0.5rem;
    min-height: 100vh;
}

/* Header */
.dashboard-header {
    padding: 2rem;
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
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--info-color) 100%);
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

.header-actions {
    display: flex;
    gap: 1rem;
}

.btn-action {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.9);
    color: var(--gray-700);
    border: 1px solid var(--gray-200);
}

.btn-secondary:hover {
    background: white;
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
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

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.stat-trend.positive {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.stat-trend.negative {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger-color);
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
.main-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.content-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
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
.quick-actions-grid {
    display: grid;
    gap: 1rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    text-decoration: none;
    color: inherit;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.quick-action-item:hover {
    background: white;
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
    border-color: var(--primary-color);
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.quick-action-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
}

.quick-action-content p {
    font-size: 0.8rem;
    color: var(--gray-600);
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .main-content {
        grid-template-columns: 1fr;
    }
    
    .dashboard-container {
        padding: 1rem;
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
        padding: 1.5rem;
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

.stat-card {
    animation: fadeInUp 0.6s ease-out;
}


.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

/* Counter Animation */
.counter {
    opacity: 0;
    animation: fadeInUp 0.8s ease-out 0.5s forwards;
}



















.quick-actions-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 10px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 2rem;
    overflow: hidden;
}

.quick-actions-header {
    background:#111827 ;
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
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
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
    color: inherit;
    border: 2px solid transparent;
    background: #f8fafc;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
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

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters


    
    counters.forEach(counter => observer.observe(counter));
    
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
@endsection