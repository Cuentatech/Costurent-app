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
                    <h3 class="stat-number counter" data-target="{{ $totalClientes }}">0</h3>
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
                    <h3 class="stat-number counter" data-target="{{ $alquileresActivos }}">0</h3>
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
                    <h3 class="stat-number counter" data-target="{{ $alquileresRetrasados }}">0</h3>
                    <p class="stat-label">Alquileres Retrasados</p>
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    font-family: 'Segoe UI', sans-serif;
}

.dashboard-header {
    margin-bottom: 2rem;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: #4f46e5;
}

.dashboard-subtitle {
    font-size: 1.1rem;
    color: #6b7280;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card-inner {
    padding: 1.5rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: #6366f1;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stat-content {
    text-align: left;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #111827;
}

.stat-label {
    font-size: 1rem;
    color: #6b7280;
}

.stat-progress {
    margin-top: 1rem;
    background: #e5e7eb;
    height: 6px;
    border-radius: 4px;
    overflow: hidden;
}

.stat-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #818cf8);
    transition: width 1s ease;
}

.stat-card-success .stat-icon {
    background: #10b981;
}

.stat-card-warning .stat-icon {
    background: #f59e0b;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const counters = document.querySelectorAll('.counter');
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const increment = target / 100;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 10);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
                observer.unobserve(counter);
            }
        });
    }, { threshold: 1.0 });

    counters.forEach(counter => observer.observe(counter));

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
