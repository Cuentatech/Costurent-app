{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Panel de Administración</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-white bg-primary">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-people-fill display-4 me-3"></i>
                    <div>
                        <h5>Total Clientes</h5>
                        <h3>{{ $totalClientes }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-white bg-success">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-bag-check-fill display-4 me-3"></i>
                    <div>
                        <h5>Alquileres Activos</h5>
                        <h3>{{ $alquileresActivos }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-white bg-warning">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-clock-history display-4 me-3"></i>
                    <div>
                        <h5>Alquileres Retrasados</h5>
                        <h3>{{ $alquileresRetrasados }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Opciones de gestión --}}
    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people display-3 text-primary mb-3"></i>
                    <h4>Gestión de Clientes</h4>
                    <p class="text-muted">Ver y administrar los usuarios registrados como clientes.</p>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-primary">Ver Clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-person-badge display-3 text-success mb-3"></i>
                    <h4>Gestión de Disfraces</h4>
                    <p class="text-muted">Añade, edita o elimina disfraces disponibles.</p>
                    <a href="{{ route('admin.disfraces.index') }}" class="btn btn-success">Ver Disfraces</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
