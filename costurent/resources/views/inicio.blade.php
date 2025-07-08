<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CostuRent - Alquiler de Disfraces</title>

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
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      overflow-x: hidden;
      transition: background-image 2s ease-in-out;
      padding-top: 80px;
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
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

    /* HERO SECTION */
    .hero-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      position: relative;
      padding: 2rem 0;
    }

    .hero-section .container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
    }

    .hero-content {
      z-index: 2;
      max-width: 850px;
      padding: 3rem;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 32px;
      backdrop-filter: blur(20px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.1);
      animation: fadeInUp 1.2s cubic-bezier(0.4, 0, 0.2, 1);
      margin: 0 auto;
    }

    .hero-title {
      font-size: 4rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-shadow: 0 4px 30px rgba(255, 255, 255, 0.3);
      letter-spacing: -1px;
      background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.8) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-subtitle {
      font-size: 1.4rem;
      margin-bottom: 1rem;
      opacity: 0.9;
      font-weight: 400;
      text-shadow: 0 2px 10px rgba(255, 255, 255, 0.2);
    }

    .hero-description {
      font-size: 1.1rem;
      margin-bottom: 2.5rem;
      opacity: 0.85;
      line-height: 1.7;
      font-weight: 300;
    }

    .btn-group-hero {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-hero {
      padding: 0.875rem 2rem;
      border-radius: 16px;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: none;
      cursor: pointer;
      font-size: 1rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      min-width: 160px;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .btn-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transform: translateX(-100%);
      transition: transform 0.6s ease;
    }

    .btn-hero:hover::before {
      transform: translateX(100%);
    }

    .btn-primary-hero {
      background: linear-gradient(135deg, rgba(147, 51, 234, 0.9), rgba(219, 39, 119, 0.9));
      color: white;
      box-shadow: 0 8px 25px rgba(147, 51, 234, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-primary-hero:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(147, 51, 234, 0.4);
      color: white;
    }

    .btn-secondary-hero {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
    }

    .btn-secondary-hero:hover {
      background: rgba(255, 255, 255, 0.2);
      border-color: rgba(255, 255, 255, 0.3);
      transform: translateY(-3px);
      color: white;
    }

    /* FEATURES */
    .features-section {
      padding: 5rem 0;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #fff;
      text-align: center;
      text-shadow: 0 2px 20px rgba(255, 255, 255, 0.3);
    }

    .section-subtitle {
      font-size: 1.1rem;
      color: rgba(255, 255, 255, 0.8);
      text-align: center;
      margin-bottom: 3rem;
      font-weight: 300;
    }

    .feature-card {
      background: rgba(255, 255, 255, 0.08);
      border-radius: 24px;
      padding: 2.5rem 2rem;
      text-align: center;
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      height: 100%;
      color: white;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .feature-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
      background: rgba(255, 255, 255, 0.12);
    }

    .feature-icon {
      font-size: 3rem;
      margin-bottom: 1.5rem;
      color: rgba(147, 51, 234, 0.9);
      text-shadow: 0 0 20px rgba(147, 51, 234, 0.5);
    }

    .feature-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #fff;
    }

    .feature-description {
      color: rgba(255, 255, 255, 0.8);
      line-height: 1.6;
      font-size: 0.95rem;
      font-weight: 300;
    }

    /* CATALOG */
    .catalogo-card {
      flex: 0 0 300px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(15px);
      border-radius: 24px;
      padding: 1.5rem;
      margin: 0 0.75rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      flex-direction: column;
    }

    .catalogo-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
      background: rgba(255, 255, 255, 0.12);
    }

    .catalogo-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 16px;
      transition: transform 0.3s ease;
    }

    .catalogo-card:hover img {
      transform: scale(1.03);
    }

    .catalogo-card h5 {
      color: #fff;
      margin-top: 1rem;
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
    }

    .catalogo-card p {
      color: rgba(255, 255, 255, 0.8);
      font-size: 0.9rem;
      margin-bottom: 1rem;
      font-weight: 300;
      flex-grow: 1;
    }

    .btn-obtener {
      background: linear-gradient(135deg, rgba(147, 51, 234, 0.9), rgba(219, 39, 119, 0.9));
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);
      margin-top: auto;
    }

    .btn-obtener:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(147, 51, 234, 0.4);
      color: white;
      text-decoration: none;
    }

    .catalogo-slider {
      display: flex;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding: 1rem;
      gap: 1rem;
    }

    .catalogo-slider::-webkit-scrollbar {
      display: none;
    }

    .flecha {
      background: rgba(146, 51, 234, 0.24);
      border: none;
      color: #fff;
      font-size: 1.5rem;
      padding: 1rem;
      border-radius: 50%;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 2;
      transition: all 0.3s ease;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .flecha:hover {
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      transform: translateY(-50%) scale(1.1);
    }

    .flecha.izquierda {
      left: -20px;
    }

    .flecha.derecha {
      right: -20px;
    }

    /* STATS */
    .stats-section {
      padding: 4rem 0;
      background: rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(10px);
    }

    .stat-item {
      text-align: center;
      padding: 2rem 1rem;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      margin-bottom: 2rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
    }

    .stat-item:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
      background: rgba(255, 255, 255, 0.12);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #fff;
      text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    .stat-label {
      font-size: 1rem;
      color: rgba(255, 255, 255, 0.8);
      font-weight: 400;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.8rem;
      }

      .hero-subtitle {
        font-size: 1.2rem;
      }

      .btn-group-hero {
        flex-direction: column;
        align-items: center;
      }

      .btn-hero {
        width: 100%;
        max-width: 280px;
      }

      .catalogo-card {
        flex: 0 0 280px;
      }
    }

    @media (max-width: 576px) {
      .hero-content {
        padding: 2rem;
        margin: 0 1rem;
      }

      .catalogo-card {
        flex: 0 0 250px;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <header class="main-header">
    <nav class="navbar navbar-expand-lg px-4">
      <div class="container">
        <a class="navbar-brand" href="#">
          <i class="fas fa-mask logo-icon"></i>
          CostuRent
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav gap-2">
            <li class="nav-item">
              <a class="nav-link active" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#catalogo">Catálogo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contacto">Contacto</a>
            </li>
            <a href="{{ route('login') }}" class="btn btn-account ms-3 d-flex align-items-center justify-content-center" title="Mi cuenta">
            <i class="fas fa-user-secret"></i>
            </a>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- HERO -->
  <section class="hero-section">
    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title">CostuRent</h1>
        <p class="hero-subtitle">Tu tienda de alquiler de disfraces favorita</p>
        <p class="hero-description">
          Encuentra el disfraz perfecto para cualquier ocasión. Tenemos la colección más amplia
          de disfraces de calidad para hacer realidad tus sueños y fantasías.
        </p>
        <div class="btn-group-hero">
          <a href="login" class="btn-hero btn-primary-hero">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
          </a>
          <a href="register" class="btn-hero btn-secondary-hero">
            <i class="fas fa-user-plus"></i> Registrarse
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="features-section">
    <div class="container">
      <h2 class="section-title">¿Por qué elegirnos?</h2>
      <p class="section-subtitle">Ofrecemos la mejor experiencia en alquiler de disfraces</p>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-mask"></i>
            </div>
            <h3 class="feature-title">Disfraces Únicos</h3>
            <p class="feature-description">
              Amplia variedad de disfraces para todas las edades y ocasiones. Desde clásicos hasta los más modernos.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-star"></i>
            </div>
            <h3 class="feature-title">Calidad Premium</h3>
            <p class="feature-description">
              Todos nuestros disfraces están confeccionados con materiales de alta calidad y son revisados constantemente.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-clock"></i>
            </div>
            <h3 class="feature-title">Servicio Rápido</h3>
            <p class="feature-description">
              Reserva online y recoge el mismo día. Proceso simple y rápido para que no pierdas tiempo.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CATALOG -->
  <section id="catalogo" class="py-5">
    <div class="container">
      <h2 class="section-title">Catálogo</h2>
      <p class="section-subtitle">Explora nuestros disfraces destacados y vive la fantasía</p>
      <div class="catalogo-wrapper position-relative">
        <button class="flecha izquierda" onclick="moverCatalogo(-1)">
          <i class="fas fa-chevron-left"></i>
        </button>
        <div class="catalogo-slider" id="catalogoSlider">
          <div class="catalogo-card">
            <img src="{{ asset('img/disfraces/disfraz1.jpg') }}" alt="Mago Místico">
            <h5>Mago Místico</h5>
            <p>Un clásico hechicero con túnica y sombrero de estrellas.</p>
            <a href="/login" class="btn-obtener">
              <i class="fas fa-shopping-cart"></i> Obtener
            </a>
          </div>
          <div class="catalogo-card">
            <img src="{{ asset('img/disfraces/disfraz2.jpg') }}" alt="Fantasma Divertido">
            <h5>Fantasma Divertido</h5>
            <p>Para asustar y hacer reír al mismo tiempo.</p>
            <a href="/login" class="btn-obtener">
              <i class="fas fa-shopping-cart"></i> Obtener
            </a>
          </div>
          <div class="catalogo-card">
            <img src="{{ asset('img/disfraces/disfraz3.jpg') }}" alt="Princesa Real">
            <h5>Princesa Real</h5>
            <p>Con vestidos brillantes y detalles encantadores.</p>
            <a href="/login" class="btn-obtener">
              <i class="fas fa-shopping-cart"></i> Obtener
            </a>
          </div>
          <div class="catalogo-card">
            <img src="{{ asset('img/disfraces/disfraz4.jpg') }}" alt="Animalito Tierno">
            <h5>Animalito Tierno</h5>
            <p>Perfecto para los más pequeños de casa.</p>
            <a href="/login" class="btn-obtener">
              <i class="fas fa-shopping-cart"></i> Obtener
            </a>
          </div>
          <div class="catalogo-card">
            <img src="{{ asset('img/disfraces/disfraz5.jpg') }}" alt="Ninja Secreto">
            <h5>Ninja Secreto</h5>
            <p>Agilidad y misterio en un solo disfraz.</p>
            <a href="/login" class="btn-obtener">
              <i class="fas fa-shopping-cart"></i> Obtener
            </a>
          </div>
          <div class="catalogo-card">
            <img src="{{ asset('img/disfraces/disfraz6.jpg') }}" alt="Robot del Futuro">
            <h5>Robot del Futuro</h5>
            <p>Brilla con luces y sonidos increíbles.</p>
            <a href="/login" class="btn-obtener">
              <i class="fas fa-shopping-cart"></i> Obtener
            </a>
          </div>
        </div>
        <button class="flecha derecha" onclick="moverCatalogo(1)">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section class="stats-section">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-6">
          <div class="stat-item">
            <div class="stat-number">500+</div>
            <div class="stat-label">Disfraces Disponibles</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-item">
            <div class="stat-number">1000+</div>
            <div class="stat-label">Clientes Satisfechos</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-item">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Atención Online</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-item">
            <div class="stat-number">5★</div>
            <div class="stat-label">Calificación Promedio</div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- FOOTER / CONTACTO -->
<footer id="contacto" class="text-white pt-5 pb-4" style="background: linear-gradient(135deg, #2e2e2e, #1a1a1a);">
  <div class="container">
    <div class="row g-5 align-items-start">
      
      <!-- TEXTO Y LOGO -->
      <div class="col-md-4">
        <h4 class="fw-bold text-uppercase">CostuRent</h4>
        <p class="text-light small">Alquiler de disfraces inolvidables para tus mejores momentos. Conócenos y diviértete con estilo.</p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-light"><i class="fab fa-facebook fa-lg"></i></a>
          <a href="#" class="text-light"><i class="fab fa-instagram fa-lg"></i></a>
          <a href="#" class="text-light"><i class="fab fa-tiktok fa-lg"></i></a>
        </div>
      </div>

      <!-- INFO DE CONTACTO -->
      <div class="col-md-4">
        <h5 class="fw-semibold text-uppercase mb-3">Contáctanos</h5>
        <p class="mb-2"><i class="fas fa-phone-alt me-2"></i><strong>+51 999 888 777</strong><br><span class="small">Lunes a domingo: 8:00 AM – 10:00 PM</span></p>
        <p class="mb-2"><i class="fas fa-envelope me-2"></i>info@costurent.com</p>
        <p><i class="fas fa-map-marker-alt me-2"></i>Av. Los Disfraces 123, Ventanilla, Callao</p>
      </div>

      <!-- MAPA EMBEBIDO -->
      <div class="col-md-4">
        <div class="rounded-4 overflow-hidden position-relative shadow">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.616210844356!2d-77.11377668515236!3d-11.867625741013333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105cf3ea2d019f3%3A0xd5d42e2dbf2c39f2!2sAv.%20Los%20Disfraces%20123%2C%20Ventanilla%2017021%2C%20Callao!5e0!3m2!1ses-419!2spe!4v1720376760065!5m2!1ses-419!2pe"
            width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
          <div style="
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(147, 51, 234, 0.9), transparent);
            color: #fff;
            padding: 1.5rem;
            text-align: center;
          ">
            <h6 class="mb-0">¡Te esperamos!</h6>
            <small class="fst-italic">Ven y encuentra el disfraz perfecto</small>
          </div>
        </div>
      </div>

    </div>

    <!-- COPYRIGHT -->
    <div class="text-center mt-4 pt-3 border-top border-secondary text-secondary small">
      &copy; 2025 CostuRent. Todos los derechos reservados.
    </div>
  </div>
</footer>


  <script>
    function moverCatalogo(direccion) {
      const slider = document.getElementById('catalogoSlider');
      const scrollAmount = 320;
      slider.scrollBy({ left: direccion * scrollAmount, behavior: 'smooth' });
    }
  </script>

  <!-- JS CAMBIO DE FONDO -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const fondos = [
        "{{ asset('img/fondo1.jpg') }}",
        "{{ asset('img/fondo2.jpg') }}",
        "{{ asset('img/fondo3.jpg') }}",
        "{{ asset('img/fondo4.jpg') }}",
        "{{ asset('img/fondo5.jpg') }}",
        "{{ asset('img/fondo6.jpg') }}",
        "{{ asset('img/fondo7.jpg') }}"
      ];

      let index = 0;
      const body = document.body;

      function cambiarFondo() {
        body.style.backgroundImage = `url('${fondos[index]}')`;
        index = (index + 1) % fondos.length;
      }

      cambiarFondo();
      setInterval(cambiarFondo, 3000);
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>