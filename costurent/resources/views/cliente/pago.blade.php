@extends('layouts.app')

@section('content')
    <style>
        .pago-container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(137, 170, 137, 0.15);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .pago-container h2 {
            color: #4B493E;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
            color: #4B493E;
        }

        .btn-pagar {
            background-color: #89AA89;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 10px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-pagar:hover {
            background-color: #6a8b6a;
        }

        .metodo-pago-option {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .metodo-pago-option img {
            width: 40px;
            height: auto;
        }
    </style>

    <div class="pago-container">
        <h2>Confirmar Pago</h2>

        <form action="{{ route('cliente.carrito.procesarPago') }}" method="POST">
            @csrf
            <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
            <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">

            <div class="form-group mb-3">
                <label>Método de pago:</label>
                <div class="metodo-pago-option">
                    <input type="radio" name="metodo_pago" value="tarjeta" required>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/MasterCard_Logo.svg" alt="MasterCard">
                    Tarjeta de crédito/débito
                </div>
                <div class="metodo-pago-option">
                    <input type="radio" name="metodo_pago" value="paypal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
                    PayPal
                </div>
                <div class="metodo-pago-option">
                    <input type="radio" name="metodo_pago" value="yape">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3e/Yape_logo.png" alt="Yape">
                    Yape
                </div>
                <div class="metodo-pago-option">
                    <input type="radio" name="metodo_pago" value="plin">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4b/Logo_Plin.png" alt="Plin">
                    Plin
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Número de tarjeta:</label>
                <input type="text" name="numero_tarjeta" class="form-control" placeholder="**** **** **** ****" required>
            </div>

            <div class="form-group mb-3">
                <label>Nombre en la tarjeta:</label>
                <input type="text" name="nombre_tarjeta" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Fecha de expiración:</label>
                <input type="month" name="expiracion" class="form-control" required>
            </div>

            <div class="form-group mb-4">
                <label>CVV:</label>
                <input type="password" name="cvv" class="form-control" maxlength="4" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-pagar">Confirmar y Pagar</button>
            </div>
        </form>
    </div>
@endsection