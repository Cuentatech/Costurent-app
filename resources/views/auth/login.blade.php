@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header text-center bg-primary text-white">
          <h4>Iniciar Sesión</h4>
        </div>
        <div class="card-body">
          @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Selector de rol con circulitos normales -->
            <div class="mb-4 text-center">
              <label class="form-label d-block mb-2">Selecciona tu rol:</label>
              <div class="d-flex justify-content-center gap-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rol" id="rol_admin" value="administrador" required>
                  <label class="form-check-label" for="rol_admin">
                    Administrador
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rol" id="rol_cliente" value="cliente" required>
                  <label class="form-check-label" for="rol_cliente">
                    Cliente
                  </label>
                </div>
              </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" required value="{{ old('correo') }}">
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="clave" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="clave" name="clave" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
          </form>

          <!-- Enlace para registrarse solo si es cliente -->
          <div class="text-center mt-3" id="registro-link" style="display: none;">
            <a href="{{ route('register') }}" class="text-decoration-none">¿No tienes cuenta? Regístrate</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Mostrar enlace solo para clientes -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const adminRadio = document.getElementById('rol_admin');
    const clienteRadio = document.getElementById('rol_cliente');
    const registroLink = document.getElementById('registro-link');

    function toggleRegistroLink() {
      registroLink.style.display = clienteRadio.checked ? 'block' : 'none';
    }

    adminRadio.addEventListener('change', toggleRegistroLink);
    clienteRadio.addEventListener('change', toggleRegistroLink);
  });
</script>
@endsection
