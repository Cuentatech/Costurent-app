@extends('layouts.cliente')

@section('title', 'Mi Carrito')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Mi Carrito</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($items->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Disfraz</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->disfraz->nombre }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>S/. {{ $item->disfraz->precio }}</td>
                            <td>S/. {{ $item->cantidad * $item->disfraz->precio }}</td>
                            <td>
                                <form action="{{ route('cliente.carrito.eliminar', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Checkout (opcional por ahora) -->
            <div class="mt-4 text-end">
                <a href="{{ route('cliente.carrito.checkout') }}" class="btn btn-success">Proceder al alquiler</a>
            </div>

        @else
            <p>No tienes disfraces en tu carrito aún.</p>
        @endif
    </div>
@endsection