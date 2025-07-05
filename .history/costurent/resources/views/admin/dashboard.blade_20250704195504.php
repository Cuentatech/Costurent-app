{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4 fw-bold text-dark">Panel de Administración</h1>

    {{-- Tarjetas de estadísticas --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient text-white" style="background: linear-gradient(135deg, #0d6efd, #4f9eff);">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-people-fill display-5 me-3"></i>
                    <div>
                        <h6 class="mb-1">Total de Clientes</h6>
                        <h3 class="fw-bold">{{ $totalClientes }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient text-white" style="background: linear-gradient(135deg, #198754, #50c878);">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-bag-check-fill display-5 me-3"></i>
                    <div>
                        <h6 class="mb-1">Alquileres Activos</h6>
                        <h3 class="fw-bold">{{ $alquileresActivos }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient text-white" style="background: linear-gradient(135deg, #ffc107, #ffdd57);">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-clock-history display-5 me-3"></i>
                    <div>
                        <h6 class="mb-1">Alquileres Retrasados</h6>
                        <h3 class="fw-bold">{{ $alquileresRetrasados }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Opciones de gestión --}}
    <div class="row mt-5 g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people display-3 text-primary mb-3"></i>
                    <h5 class="fw-bold">Gestión de Clientes</h5>
                    <p class="text-muted">Visualiza y administra los usuarios registrados como clientes.</p>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-primary w-100">Ver Clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-person-badge display-3 text-success mb-3"></i>
                    <h5 class="fw-bold">Gestión de Disfraces</h5>
                    <p class="text-muted">Añade, edita o elimina disfraces disponibles en el sistema.</p>
                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-outline-success w-100">Ver Disfraces</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-bag-check display-3 text-warning mb-3"></i>
                    <h5 class="fw-bold">Gestión de Alquileres</h5>
                    <p class="text-muted">Controla y monitorea los alquileres registrados.</p>
                    <a href="{{ route('admin.alquileres.index') }}" class="btn btn-outline-warning w-100">Ver Alquileres</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
