@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-5 text-center fw-bold text-dark">
        <i class="bi bi-speedometer2 me-2 text-primary"></i>Panel de Administración
    </h1>

    {{-- Tarjetas de estadísticas --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 text-white" style="background: linear-gradient(135deg, #0d6efd, #4f9eff);">
                <div class="card-body d-flex align-items-center py-4">
                    <i class="bi bi-people-fill display-4 me-4"></i>
                    <div>
                        <h6 class="text-uppercase mb-1">Total de Clientes</h6>
                        <h2 class="fw-bold">{{ $totalClientes }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 text-white" style="background: linear-gradient(135deg, #198754, #4ade80);">
                <div class="card-body d-flex align-items-center py-4">
                    <i class="bi bi-bag-check-fill display-4 me-4"></i>
                    <div>
                        <h6 class="text-uppercase mb-1">Alquileres Activos</h6>
                        <h2 class="fw-bold">{{ $alquileresActivos }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 text-dark" style="background: linear-gradient(135deg, #ffc107, #ffe066);">
                <div class="card-body d-flex align-items-center py-4">
                    <i class="bi bi-clock-history display-4 me-4"></i>
                    <div>
                        <h6 class="text-uppercase mb-1">Alquileres Retrasados</h6>
                        <h2 class="fw-bold">{{ $alquileresRetrasados }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Opciones de gestión --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                <div class="card-body py-5">
                    <i class="bi bi-people display-3 text-primary mb-3"></i>
                    <h5 class="fw-bold">Gestión de Clientes</h5>
                    <p class="text-muted">Visualiza y administra los usuarios registrados como clientes.</p>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-primary rounded-pill mt-3 px-4">Ver Clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                <div class="card-body py-5">
                    <i class="bi bi-person-badge display-3 text-success mb-3"></i>
                    <h5 class="fw-bold">Gestión de Disfraces</h5>
                    <p class="text-muted">Agrega, edita o elimina los disfraces del sistema.</p>
                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-success rounded-pill mt-3 px-4">Ver Disfraces</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                <div class="card-body py-5">
                    <i class="bi bi-bag-check display-3 text-warning mb-3"></i>
                    <h5 class="fw-bold">Gestión de Alquileres</h5>
                    <p class="text-muted">Controla y monitorea los alquileres registrados en el sistema.</p>
                    <a href="{{ route('admin.alquileres.index') }}" class="btn btn-warning text-white rounded-pill mt-3 px-4">Ver Alquileres</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
