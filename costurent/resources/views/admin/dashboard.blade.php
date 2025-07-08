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
    <div class="main-dashboard-content">
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
                        <a href="{{ route('admin.clientes.index') }}" class="quick-action-link quick-action-primary">
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
                        <a href="{{ route('admin.alquileres.index') }}" class="quick-action-link quick-action-success">
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
                        <a href="{{ route('admin.disfraces.index') }}" class="quick-action-link quick-action-warning">
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

@push('styles')
<style>
:root {
    --primary-color: #8b5cf6;
    --primary-light: #a78bfa;
    --primary-dark: #7c3aed;
    --secondary-color: #ec4899;
    --secondary-light: #f472b6;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #3b82f6;
    --glass-bg: rgba(255, 255, 255, 0.1);
    --glass-border: rgba(255, 255, 255, 0.2);
    --glass-shadow: 0 8px 32px rgba(139, 92, 246, 0.15);
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --text-light: rgba(255, 255, 255, 0.9);
    --border-radius: 20px;
}

/* Background gradient */


.dashboard-container > * {
    position: relative;
    z-index: 1;
}

/* Header */
.dashboard-header {
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.dashboard-title {
    font-size: 3rem;
    font-weight: 900;
    background: linear-gradient(135deg, 
        rgba(255, 255, 255, 0.95) 0%, 
        rgba(255, 255, 255, 0.8) 50%, 
        rgba(139, 92, 246, 0.9) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
    margin-bottom: 0.5rem;
    filter: drop-shadow(0 0 20px rgba(139, 92, 246, 0.3));
}

.dashboard-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.2rem;
    font-weight: 500;
    margin: 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--glass-shadow);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    animation: fadeInUp 0.8s ease-out;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(255, 255, 255, 0.1) 0%, 
        rgba(255, 255, 255, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(139, 92, 246, 0.3);
    border-color: rgba(255, 255, 255, 0.3);
}

.stat-card-inner {
    padding: 2rem;
    position: relative;
    z-index: 2;
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    background: linear-gradient(135deg, 
        rgba(139, 92, 246, 0.8) 0%, 
        rgba(168, 85, 247, 0.6) 100%);
    color: white;
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    margin-bottom: 1.5rem;
}

.stat-card-success .stat-icon {
    background: linear-gradient(135deg, 
        rgba(16, 185, 129, 0.8) 0%, 
        rgba(52, 211, 153, 0.6) 100%);
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
}

.stat-card-warning .stat-icon {
    background: linear-gradient(135deg, 
        rgba(245, 158, 11, 0.8) 0%, 
        rgba(251, 191, 36, 0.6) 100%);
    box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
}

.stat-number {
    font-size: 3rem;
    font-weight: 900;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.stat-label {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
}

.stat-progress {
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
    position: relative;
}

.stat-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, 
        rgba(139, 92, 246, 0.8) 0%, 
        rgba(168, 85, 247, 1) 100%);
    border-radius: 4px;
    transition: width 1.5s ease-out;
    box-shadow: 0 0 20px rgba(139, 92, 246, 0.6);
}

.stat-card-success .stat-progress-bar {
    background: linear-gradient(90deg, 
        rgba(16, 185, 129, 0.8) 0%, 
        rgba(52, 211, 153, 1) 100%);
    box-shadow: 0 0 20px rgba(16, 185, 129, 0.6);
}

.stat-card-warning .stat-progress-bar {
    background: linear-gradient(90deg, 
        rgba(245, 158, 11, 0.8) 0%, 
        rgba(251, 191, 36, 1) 100%);
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.6);
}

/* Main Content */
.main-dashboard-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.content-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    transition: all 0.3s ease;
}

.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(139, 92, 246, 0.2);
}

.card-header {
    padding: 2rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: linear-gradient(135deg, 
        rgba(255, 255, 255, 0.1) 0%, 
        rgba(255, 255, 255, 0.05) 100%);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.95);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.btn-ghost {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 0.75rem;
    border-radius: 12px;
    color: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-ghost:hover {
    background: rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 1);
    transform: scale(1.05);
}

.card-body {
    padding: 2rem;
}

/* Timeline */
.timeline-item {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 22px;
    top: 50px;
    width: 2px;
    height: calc(100% + 1rem);
    background: linear-gradient(180deg, 
        rgba(139, 92, 246, 0.5) 0%, 
        rgba(255, 255, 255, 0.1) 100%);
}

.timeline-marker {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
}

.timeline-marker-primary {
    background: linear-gradient(135deg, 
        rgba(139, 92, 246, 0.8) 0%, 
        rgba(168, 85, 247, 0.6) 100%);
}

.timeline-marker-success {
    background: linear-gradient(135deg, 
        rgba(16, 185, 129, 0.8) 0%, 
        rgba(52, 211, 153, 0.6) 100%);
}

.timeline-marker-warning {
    background: linear-gradient(135deg, 
        rgba(245, 158, 11, 0.8) 0%, 
        rgba(251, 191, 36, 0.6) 100%);
}

.timeline-marker-danger {
    background: linear-gradient(135deg, 
        rgba(239, 68, 68, 0.8) 0%, 
        rgba(248, 113, 113, 0.6) 100%);
}

.timeline-content {
    flex: 1;
    padding-top: 0.5rem;
}

.timeline-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 0.5rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
}

.timeline-time {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.4);
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 1rem;
    font-weight: 600;
}

.empty-state p {
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
    font-size: 1.1rem;
}

/* Quick Actions */
.quick-actions-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius);
    box-shadow: var(--glass-shadow);
    overflow: hidden;
    transition: all 0.3s ease;
}

.quick-actions-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(139, 92, 246, 0.2);
}

.quick-actions-header {
    background: linear-gradient(135deg, 
        rgba(31, 41, 55, 0.8) 0%, 
        rgba(75, 85, 99, 0.6) 100%);
    backdrop-filter: blur(10px);
    color: rgba(255, 255, 255, 0.95);
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.quick-actions-header i {
    font-size: 1.8rem;
    color: #8b5cf6;
}

.quick-actions-header h5 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 700;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.quick-actions-body {
    padding: 2rem;
}

.quick-actions-grid {
    display: grid;
    gap: 1.5rem;
}

.quick-action-link {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 2rem;
    border-radius: 18px;
    text-decoration: none;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.quick-action-primary {
    background: linear-gradient(135deg, 
        rgba(139, 92, 246, 0.6) 0%, 
        rgba(168, 85, 247, 0.4) 100%);
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
}

.quick-action-success {
    background: linear-gradient(135deg, 
        rgba(16, 185, 129, 0.6) 0%, 
        rgba(52, 211, 153, 0.4) 100%);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}

.quick-action-warning {
    background: linear-gradient(135deg, 
        rgba(245, 158, 11, 0.6) 0%, 
        rgba(251, 191, 36, 0.4) 100%);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
}

.quick-action-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(255, 255, 255, 0.1) 0%, 
        rgba(255, 255, 255, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.quick-action-link:hover::before {
    opacity: 1;
}

.quick-action-link:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 40px rgba(139, 92, 246, 0.4);
    border-color: rgba(255, 255, 255, 0.3);
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.action-text {
    flex: 1;
    font-size: 1.1rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.action-arrow {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.quick-action-link:hover .action-arrow {
    transform: translateX(5px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .main-dashboard-content {
        grid-template-columns: 1fr;
    }
    
    .dashboard-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card-inner {
        padding: 1.5rem;
    }
    
    .card-header, .card-body {
        padding: 1.5rem;
    }
    
    .quick-actions-body {
        padding: 1.5rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.3s; }
.stat-card:nth-child(3) { animation-delay: 0.5s; }
.stat-card:nth-child(4) { animation-delay: 0.7s; }

/* Glow effects */
.stat-card:hover .stat-number {
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
}

.quick-action-link:hover .action-text {
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced progress bar animation
    const progressBars = document.querySelectorAll('.stat-progress-bar');
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const width = entry.target.style.width;
                entry.target.style.width = '0%';
                setTimeout(() => {
                    entry.target.style.width = width;
                }, 800);
                progressObserver.unobserve(entry.target);
            }
        });
    });
    
    progressBars.forEach(bar => progressObserver.observe(bar));

    // Floating animation for cards
    const cards = document.querySelectorAll('.stat-card, .content-card, .quick-actions-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.2}s`;
    });

    // Parallax effect for background
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.dashboard-container::before');
        if (parallax) {
            parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
});

</script>
 <!-- JS CAMBIO DE FONDO -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const fondos = [
        "{{ asset('img/fondo1.jpg') }}",
        "{{ asset('img/fondo2.jpg') }}",
        "{{ asset('img/fondo3.jpg') }}",
        "{{ asset('img/fondo4.jpg') }}",
        "{{ asset('img/fondo5.jpg') }}",
        "{{ asset('img/fondo6.jpg') }}",
        "{{ asset('img/fondo7.jpg') }}"
      ];

      let index = 0;
      const body = document.body;

      function cambiarFondo() {
        body.style.backgroundImage = `url('${fondos[index]}')`;
        index = (index + 1) % fondos.length;
      }

      cambiarFondo();
      setInterval(cambiarFondo, 2600);
    });
  </script>
   <!-- JS CAMBIO DE FONDO -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endpush
@endsection