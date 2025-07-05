@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-center text-white bg-primary bg-gradient rounded-top">
          <h4 class="mb-0 py-2">Registro de Cliente</h4>
        </div>
        <div class="card-body p-4">

          @if ($errors->any())
            <div class="alert alert-danger rounded-3">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-3">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" class="form-control" name="apellido" id="apellido" value="{{ old('apellido') }}" required>
            </div>

            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" name="correo" id="correo" value="{{ old('correo') }}" required>
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono (opcional)</label>
              <input type="tel" class="form-control" name="telefono" id="telefono" value="{{ old('telefono') }}">
            </div>

            <div class="mb-3">
              <label for="clave" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="clave" id="clave" required>
            </div>

            <div class="mb-3">
              <label for="clave_confirmation" class="form-label">Confirmar Contraseña</label>
              <input type="password" class="form-control" name="clave_confirmation" id="clave_confirmation" required>
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary">Registrarse</button>
            </div>

            <div class="text-center">
              <small>¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="text-primary text-decoration-none">Inicia sesión</a>
              </small>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
