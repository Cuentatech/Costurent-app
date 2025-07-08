<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CostuRent - Registrarse</title>

  <!-- Bootstrap y Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    .btn-account {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: white;
    padding: 0.6rem 0.8rem;
    border-radius: 12px;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(15px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  }

  .btn-account:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: scale(1.05);
    color: white;
  }

    :root {
      --morado: #9333ea;
      --rosa: #db2777;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      transition: background-image 2s ease-in-out;
      padding-top: 100px;
      overflow-x: hidden;
    }

      /* HEADER */
  .main-header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 999;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  }

  .navbar {
    padding: 1rem 0;
  }

  .navbar-brand {
    color: #fff !important;
    font-size: 1.75rem;
    font-weight: 700;
    text-shadow: 0 2px 20px rgba(255, 255, 255, 0.3);
    letter-spacing: -0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .navbar-brand .logo-icon {
    font-size: 1.5rem;
    color: rgba(147, 51, 234, 0.9);
    text-shadow: 0 0 20px rgba(147, 51, 234, 0.5);
  }

  .navbar .nav-link {
    color: rgba(255, 255, 255, 0.9) !important;
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    position: relative;
    padding: 0.5rem 1rem !important;
    border-radius: 8px;
  }

  .navbar .nav-link::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .navbar .nav-link:hover::before,
  .navbar .nav-link.active::before {
    opacity: 1;
  }

  .navbar .nav-link:hover {
    color: #fff !important;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
  }

  .btn-account {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: white;
    padding: 0.6rem 0.8rem;
    border-radius: 12px;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(15px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  }

  .btn-account:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: scale(1.05);
    color: white;
  }
    /* FORM CARD */
    .register-card {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(20px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 24px;
      max-width: 550px;
      padding: 3rem;
      color: white;
      margin: auto;
    }

    .form-label {
      color: white;
      font-weight: 500;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 10px;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.15);
      border-color: var(--rosa);
      box-shadow: none;
    }

    .btn-register {
      background: linear-gradient(145deg, var(--morado), var(--rosa));
      color: white;
      font-weight: 600;
      padding: 12px;
      border-radius: 12px;
      border: none;
      width: 100%;
      transition: 0.3s;
    }

    .btn-register:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(147, 51, 234, 0.3);
    }
    .logo-title {
      font-size: 2.2rem;
      font-weight: 700;
      background: linear-gradient(to left, #db2777, #9333ea); /* rosa a morado */
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }


    .text-white-50 {
      color: rgba(255, 255, 255, 0.6);
    }

    .alert {
      background-color: rgba(255, 0, 0, 0.15);
      color: #ffb3b3;
      border: none;
      border-radius: 12px;
    }

    @media (max-width: 576px) {
      .register-card {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>

<body>
  <!-- HEADER -->
<header class="main-header">
  <nav class="navbar navbar-expand-lg px-4">
    <div class="container">
      <a class="navbar-brand" href="{{ route('inicio') }}">
        <i class="fas fa-mask logo-icon"></i>
        CostuRent
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav gap-2">
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('inicio') }}">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('inicio') }}#catalogo">Catálogo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('inicio') }}#contacto">Contacto</a>
          </li>
        </ul>

        <!-- Botón de cuenta separado del menú -->
        <a href="{{ route('login') }}" class="btn btn-account ms-3 d-flex align-items-center justify-content-center" title="Mi cuenta">
          <i class="fas fa-user-secret"></i>
        </a>
      </div>
    </div>
  </nav>
</header>


  <!-- FORMULARIO -->
  <div class="register-card">
    <div class="text-center mb-4">
      <i class="fas fa-user-plus fa-3x mb-3" style="color: var(--morado);"></i>
      <h2 class="logo-title">Registrarse</h2>
      <p class="text-white-50">Crea tu cuenta gratuita</p>
    </div>

    @if ($errors->any())
    <div class="alert p-3 mb-3">
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
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
      </div>

      <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo') }}" required>
      </div>

      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
      </div>

      <div class="mb-3">
        <label for="clave" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="clave" name="clave" required>
      </div>

      <div class="mb-3">
        <label for="clave_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="clave_confirmation" name="clave_confirmation" required>
      </div>

      <button type="submit" class="btn btn-register"><i class="fas fa-user-plus me-2"></i> Crear cuenta</button>
    </form>

    <div class="text-center mt-3">
      <small class="text-white-50">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-decoration-none text-white">Inicia sesión</a></small>
    </div>
  </div>

  <!-- FONDO CAMBIANTE -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const fondos = [
        "{{ asset('img/fondo1.jpg') }}",
        "{{ asset('img/fondo2.jpg') }}",
        "{{ asset('img/fondo3.jpg') }}",
        "{{ asset('img/fondo4.jpg') }}"
      ];
      let index = 0;
      const body = document.body;

      function cambiarFondo() {
        body.style.backgroundImage = `url('${fondos[index]}')`;
        index = (index + 1) % fondos.length;
      }

      cambiarFondo(); // fondo inicial
      setInterval(cambiarFondo, 2700); // cada 5 segundos
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
