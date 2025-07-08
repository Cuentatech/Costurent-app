@extends('layouts.cliente')

@section('title', 'Checkout')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Resumen de tu Carrito</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($items->count())
            <form method="POST" action="{{ route('cliente.carrito.procesarCheckout') }}">
                @csrf
                <div class="table-responsive mb-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Disfraz</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($items as $item)
                                @php
                                    $subtotal = $item->cantidad * $item->disfraz->precio;
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $item->disfraz->nombre }}</td>
                                    <td>S/ {{ number_format($item->disfraz->precio, 2) }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>S/ {{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <label>Fecha de inicio:</label>
                    <input type="date" name="fecha_inicio" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Fecha de fin:</label>
                    <input type="date" name="fecha_fin" class="form-control" required>
                </div>

                <h4 class="mt-4">Total estimado: <strong>S/ {{ number_format($total, 2) }}</strong></h4>

                <button type="submit" class="btn btn-success mt-3">Confirmar Alquiler</button>
            </form>
        @else
            <p>No tienes disfraces en tu carrito aún.</p>
        @endif
    </div>
@endsection