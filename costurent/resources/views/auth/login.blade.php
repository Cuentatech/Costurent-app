<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión - CostuRent</title>
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
      overflow-x: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .login-card {
      background: rgba(192, 193, 224, 0.4);
      border-radius: 20px;
      max-width: 500px;
      width: 100%;
      padding: 2.5rem;
      color: white;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .form-label,
    .form-check-label {
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

    .btn-login {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      font-weight: bold;
      border: none;
      padding: 10px;
      border-radius: 10px;
      width: 100%;
    }

    .btn-login:hover {
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
  <div class="login-card">
    <div class="text-center mb-4">
      <i class="fas fa-mask fa-3x mb-2" style="color:rgba(24, 29, 68, 0.9);"></i>
      <h2 class="logo-title">CostuRent</h2>
      <p class="text-white-50">Inicia sesión en tu cuenta</p>
    </div>

    @if (session('success'))
    <div class="alert alert-success mb-3">
      {{ session('success') }}
    </div>
  @endif

    @if ($errors->any())
    <div class="alert alert-danger mb-3 p-3">
      <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
      </ul>
    </div>
  @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3 text-center">
        <label class="form-label d-block mb-2">Selecciona tu rol:</label>
        <div class="d-flex justify-content-center gap-4">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="rol" id="rol_admin" value="administrador" required>
            <label class="form-check-label" for="rol_admin">Administrador</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="rol" id="rol_cliente" value="cliente" required>
            <label class="form-check-label" for="rol_cliente">Cliente</label>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required value="{{ old('correo') }}">
      </div>

      <div class="mb-3">
        <label for="clave" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="clave" name="clave" required>
      </div>

      <button type="submit" class="btn btn-login">
        <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
      </button>
    </form>

    <div class="text-center mt-3" id="registro-link" style="display: none;">
      <a href="{{ route('register') }}" class="text-white text-decoration-underline">¿No tienes cuenta? Regístrate</a>
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

</body>

</html>