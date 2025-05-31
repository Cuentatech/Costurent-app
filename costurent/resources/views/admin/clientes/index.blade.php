@extends('layouts.app')

@section('title', 'Listado de Clientes')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Clientes Registrados</h1>

    @if($clientes->isEmpty())
        <div class="alert alert-info">No hay clientes registrados.</div>
    @else
        <table class="table table-striped table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Volver al Dashboard</a>
</div>
@endsection

