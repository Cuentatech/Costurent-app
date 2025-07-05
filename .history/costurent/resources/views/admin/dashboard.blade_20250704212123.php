@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-5 animate__animated animate__fadeInDown">
        <div>
            <h1 class="mb-2 fw-bold text-dark d-flex align-items-center">
                <span class="gradient-text">Panel de Administración</span>
            </h1>
            <h4 class="text-muted mb-0">Gestiona tu plataforma desde aquí</h4>
        </div>
    </div>

    {{-- Tarjetas estadísticas --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-card-primary animate__animated animate__fadeInUp">
                <div class="stats-overlay"></div>
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stats-icon">
                            <i class="bi bi-people-fill"></i>
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
                        </div>
                    </div>
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

    {{-- Sección de actividad reciente --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">Actividad Reciente</h5>
                </div>
                <div class="card-body p-4">
                    <div class="activity-timeline">
                        @forelse($actividades as $actividad)
                            <div class="timeline-item">
                                <div class="timeline-dot bg-{{ $actividad['color'] }}"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">
                                        <i class="bi {{ $actividad['icono'] }} me-2"></i>{{ $actividad['mensaje'] }}
                                    </h6>
                                    <small class="text-muted">{{ $actividad['fecha']->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No hay actividad reciente disponible.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
