<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrarse - CostuRent</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .register-card {
      background: rgba(192, 193, 224, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      border-radius: 20px;
      max-width: 550px;
      width: 100%;
      padding: 2.5rem;
      color: white;
    }

    .form-label {
      color: white;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.3);
      color: white;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.2);
      border-color: rgba(255, 255, 255, 0.5);
      color: white;
    }

    .btn-register {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      font-weight: bold;
      border: none;
      padding: 10px;
      border-radius: 10px;
      width: 100%;
    }

    .btn-register:hover {
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
      transform: translateY(-2px);
    }

    .alert {
      background-color: rgba(220, 53, 69, 0.2);
      color: #ff6b6b;
      border-radius: 10px;
    }

    .logo-title {
      font-size: 2rem;
      font-weight: 700;
      color: white;
      margin-bottom: 0.5rem;
    }

    .text-white-50 {
      color: rgba(255, 255, 255, 0.6);
    }
  </style>
</head>

<body>

  <div class="register-card">
    <div class="text-center mb-4">
      <i class="fas fa-user-plus fa-3x mb-2" style="color: rgba(24, 29, 68, 0.9);"></i>
      <h2 class="logo-title">CostuRent</h2>
      <p class="text-white-50">Crea tu cuenta</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger mb-3 p-3">
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

      <button type="submit" class="btn btn-register">
        <i class="fas fa-user-plus me-2"></i> Crear Cuenta
      </button>
    </form>

    <div class="text-center mt-3">
      <small class="text-white-50">¿Ya tienes una cuenta?
        <a href="{{ route('login') }}" class="text-decoration-none text-white">Inicia sesión</a>
      </small>
    </div>
  </div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const fondos = [
            "{{ asset('img/fondo1.jpg') }}",
            "{{ asset('img/fondo2.jpg') }}",
            "{{ asset('img/fondo3.jpg') }}",
            "{{ asset('img/fondo4.jpg') }}",
            "{{ asset('img/fondo5.jpg') }}",
            "{{ asset('img/fondo6.jpg') }}"
        ];

        let index = 0;
        const body = document.body;

        function cambiarFondo() {
            body.style.backgroundImage = `url('${fondos[index]}')`;
            index = (index + 1) % fondos.length;
        }

        cambiarFondo(); // primer fondo
        setInterval(cambiarFondo, 1500); // cambia cada 3 segundos
    });
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>