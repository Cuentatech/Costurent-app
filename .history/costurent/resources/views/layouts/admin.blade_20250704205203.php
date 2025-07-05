@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid px-4">
    {{-- Header --}}
    <div class="mb-5">
        <h1 class="mb-2 fw-bold text-dark d-flex align-items-center">
            <div class="p-3 rounded-3 me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="bi bi-speedometer2 text-white fs-3"></i>
            </div>
            <span class="gradient-text">Panel de Administración</span>
        </h1>
        <p class="text-muted mb-0">Gestiona tu plataforma desde aquí</p>
    </div>

    {{-- Tarjetas de estadísticas --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="stats-card stats-card-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon me-4">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Total de Clientes</h6>
                            <h2 class="fw-bold mb-0">{{ $totalClientes }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="stats-card stats-card-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon me-4">
                            <i class="bi bi-bag-check-fill"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Alquileres Activos</h6>
                            <h2 class="fw-bold mb-0">{{ $alquileresActivos }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="stats-card stats-card-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon me-4">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Alquileres Retrasados</h6>
                            <h2 class="fw-bold mb-0">{{ $alquileresRetrasados }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Opciones de gestión --}}
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="management-card">
                <div class="card-body text-center p-4">
                    <div class="management-icon mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Gestión de Clientes</h5>
                    <p class="text-muted mb-4">Visualiza y administra los usuarios registrados como clientes.</p>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-primary rounded-pill px-4">
                        Ver Clientes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="management-card">
                <div class="card-body text-center p-4">
                    <div class="management-icon mb-3">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Gestión de Disfraces</h5>
                    <p class="text-muted mb-4">Agrega, edita o elimina los disfraces del sistema.</p>
                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-success rounded-pill px-4">
                        Ver Disfraces
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="management-card">
                <div class="card-body text-center p-4">
                    <div class="management-icon mb-3">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Gestión de Alquileres</h5>
                    <p class="text-muted mb-4">Controla y monitorea los alquileres registrados.</p>
                    <a href="{{ route('admin.alquileres.index') }}" class="btn btn-warning rounded-pill px-4">
                        Ver Alquileres
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }

    .stats-card-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .stats-card-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .stats-card-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
    }

    .management-card {
        background: #fff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
        height: 100%;
    }

    .management-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.12);
    }

    .management-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #6c757d;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .management-card:hover .management-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: scale(1.05);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .stats-card, .management-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection