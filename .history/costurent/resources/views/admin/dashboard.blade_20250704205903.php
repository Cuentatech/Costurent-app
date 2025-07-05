@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid px-4">
    {{-- Header con animación --}}
    <div class="d-flex justify-content-between align-items-center mb-5 animate__animated animate__fadeInDown">
        <div>
            <h1 class="mb-2 fw-bold text-dark d-flex align-items-center">
                <div class="p-3 rounded-3 me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-speedometer2 text-white fs-3"></i>
                </div>
                <span class="gradient-text">Panel de Administración</span>
            </h1>
            <h2 class="text-muted mb-0">Gestiona tu plataforma desde aquí</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-card-primary animate__animated animate__fadeInUp">
                <div class="stats-overlay"></div>
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stats-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="stats-trend">
                            <span class="badge bg-success bg-opacity-20 text-success">
                                <i class="bi bi-arrow-up me-1"></i>+12%
                            </span>
                        </div>
                    </div>
                    <div class="stats-content">
                        <h6 class="text-uppercase mb-2 opacity-75">Total de Clientes</h6>
                        <h2 class="fw-bold mb-0 counter" data-target="{{ $totalClientes }}">0</h2>
                        <small class="opacity-75">Usuarios registrados</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-card-success animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                <div class="stats-overlay"></div>
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stats-icon">
                            <i class="bi bi-bag-check-fill"></i>
                        </div
>                    </div>
                    <div class="stats-content">
                        <h6 class="text-uppercase mb-2 opacity-75">Alquileres Activos</h6>
                        <h2 class="fw-bold mb-0 counter" data-target="{{ $alquileresActivos }}">0</h2>
                        <small class="opacity-75">En progreso</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-card-warning animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="stats-overlay"></div>
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stats-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stats-trend">
                            <span class="badge bg-warning bg-opacity-20 text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>Atención
                            </span>
                        </div>
                    </div>
                    <div class="stats-content">
                        <h6 class="text-uppercase mb-2 opacity-75">Alquileres Retrasados</h6>
                        <h2 class="fw-bold mb-0 counter" data-target="{{ $alquileresRetrasados }}">0</h2>
                        <small class="opacity-75">Requieren seguimiento</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Opciones de gestión con hover effects --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="management-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                <div class="card-gradient card-gradient-primary"></div>
                <div class="card-body text-center p-5">
                    <div class="management-icon mb-4">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Gestión de Clientes</h5>
                    <p class="text-muted mb-4">Visualiza y administra los usuarios registrados como clientes.</p>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-right me-2"></i>Ver Clientes
                    </a>
                </div>
                <div class="card-hover-effect"></div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="management-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <div class="card-gradient card-gradient-success"></div>
                <div class="card-body text-center p-5">
                    <div class="management-icon mb-4">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Gestión de Disfraces</h5>
                    <p class="text-muted mb-4">Agrega, edita o elimina los disfraces del sistema.</p>
                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-success rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-right me-2"></i>Ver Disfraces
                    </a>
                </div>
                <div class="card-hover-effect"></div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="management-card animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
                <div class="card-gradient card-gradient-warning"></div>
                <div class="card-body text-center p-5">
                    <div class="management-icon mb-4">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Gestión de Alquileres</h5>
                    <p class="text-muted mb-4">Controla y monitorea los alquileres registrados.</p>
                    <a href="{{ route('admin.alquileres.index') }}" class="btn btn-warning rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-right me-2"></i>Ver Alquileres
                    </a>
                </div>
                <div class="card-hover-effect"></div>
            </div>
        </div>
    </div>

    {{-- Sección de actividad reciente --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">Actividad Reciente</h5>
                </div>
                <div class="card-body p-4">
                    <div class="activity-timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Nuevo cliente registrado</h6>
                                <p class="text-muted mb-1">María García se registró en el sistema</p>
                                <small class="text-muted">Hace 2 horas</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Alquiler completado</h6>
                                <p class="text-muted mb-1">Disfraz de superhéroe devuelto</p>
                                <small class="text-muted">Hace 4 horas</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Alquiler próximo a vencer</h6>
                                <p class="text-muted mb-1">Disfraz de princesa - Cliente: Ana López</p>
                                <small class="text-muted">Hace 6 horas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">Acciones Rápidas</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <button class="btn btn-outline-primary rounded-pill text-start">
                            <i class="bi bi-person-plus me-3"></i>Agregar Cliente
                        </button>
                        <button class="btn btn-outline-success rounded-pill text-start">
                            <i class="bi bi-plus-circle me-3"></i>Nuevo Disfraz
                        </button>
                        <button class="btn btn-outline-warning rounded-pill text-start">
                            <i class="bi bi-calendar-plus me-3"></i>Registrar Alquiler
                        </button>
                        <button class="btn btn-outline-info rounded-pill text-start">
                            <i class="bi bi-graph-up me-3"></i>Ver Reportes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estilos CSS modernos --}}
<style>
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .stats-card-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .stats-card-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .stats-card-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }

    .stats-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
        pointer-events: none;
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
    }

    .stats-trend .badge {
        border-radius: 20px;
        padding: 8px 12px;
        font-weight: 500;
    }

    .management-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
        height: 100%;
    }

    .management-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .management-card:hover .card-hover-effect {
        opacity: 1;
    }

    .card-gradient {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
    }

    .card-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .card-gradient-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .card-gradient-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

    .card-hover-effect {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .management-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #6c757d;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .management-card:hover .management-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: scale(1.1);
    }

    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 30px;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -23px;
        top: 20px;
        bottom: -10px;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-dot {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
    }

    .counter {
        font-size: 2.5rem;
        font-weight: 700;
    }

    /* Animaciones */
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

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate__animated {
        animation-duration: 0.8s;
        animation-fill-mode: both;
    }

    .animate__fadeInUp {
        animation-name: fadeInUp;
    }

    .animate__fadeInDown {
        animation-name: fadeInDown;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .stats-card {
            margin-bottom: 1rem;
        }
        
        .management-card {
            margin-bottom: 1rem;
        }
    }
</style>

{{-- JavaScript para animaciones --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de contadores
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 segundos
        const step = target / (duration / 16); // 60 FPS
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += step;
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        // Iniciar animación cuando el elemento sea visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });
});
</script>
@endsection