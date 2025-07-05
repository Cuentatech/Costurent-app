@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4 fw-bold text-dark text-center">
        <i class="bi bi-speedometer2 me-2"></i>Panel de Administración
    </h1>

    {{-- Tarjetas de estadísticas --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 text-white bg-gradient" style="background: linear-gradient(to right, #0061ff, #60efff);">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-people-fill display-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase">Total de Clientes</h6>
                        <h2 class="fw-bold">{{ $totalClientes }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0 text-white bg-gradient" style="background: linear-gradient(to right, #00b09b, #96c93d);">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-bag-check-fill display-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase">Alquileres Activos</h6>
                        <h2 class="fw-bold">{{ $alquileresActivos }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0 text-dark bg-gradient" style="background: linear-gradient(to right, #ffdd00, #fbb034);">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-clock-history display-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase">Alquileres Retrasados</h6>
                        <h2 class="fw-bold">{{ $alquileresRetrasados }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Opciones de gestión --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-people display-3 text-primary mb-3"></i>
                    <h5 class="fw-bold">Gestión de Clientes</h5>
                    <p class="text-muted">Administra los usuarios registrados como clientes del sistema.</p>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-primary w-100">Ver Clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-person-badge display-3 text-success mb-3"></i>
                    <h5 class="fw-bold">Gestión de Disfraces</h5>
                    <p class="text-muted">Agrega, edita o elimina los disfraces disponibles en el sistema.</p>
                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-outline-success w-100">Ver Disfraces</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-bag-check display-3 text-warning mb-3"></i>
                    <h5 class="fw-bold">Gestión de Alquileres</h5>
                    <p class="text-muted">Controla los registros de alquileres y su estado.</p>
                    <a href="{{ route('admin.alquileres.index') }}" class="btn btn-outline-warning w-100">Ver Alquileres</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
