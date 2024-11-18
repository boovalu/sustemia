<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="icon" type="image/png" href="{{ url('css/imgs/favicon-32x32.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/styles.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            overflow-x: hidden; /* Evitar el scroll horizontal */
            margin: 0; /* Sin margen por defecto */
            background-color: #f8f9fa; /* Color de fondo suave */
        }
        .offcanvas {
            width: 250px; /* Ancho del menú */
        }
        .sidebar__content {
            transition: margin-left 0.3s; /* Transición suave al abrir/cerrar */
            margin-left: 0; /* Sin margen inicial */
            padding: 20px; /* Ajusta el padding según sea necesario */
            flex-grow: 1; /* Permitir que el contenido principal crezca */
        }
        .sidebar-open {
            margin-left: 250px; /* Margen cuando el menú está abierto */
        }
        .alert-container {
            margin-bottom: 1rem; /* Espacio entre alertas y contenido */
        }
        .navbar {
            background-color: #ffffff; /* Fondo blanco */
        }
        .dropdown-menu {
            min-width: 200px; /* Ancho mínimo del menú desplegable */
        }
    </style>
</head>

<body>
<div id="app">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            @auth
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Abrir menú">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @endauth
            <a class="navbar-brand text-dark" href="{{ url('/') }}">
                <img src="{{ url('css/imgs/resource/sustemia_oficial.png') }}" alt="Logo de Sustemia" height="50">
            </a>

            <div class="d-flex align-items-center ms-auto">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-icons me-2">account_circle</span> {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.view') }}">
                                    <span class="material-icons me-2">edit</span> Editar Perfil
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('auth.logout') }}" method="post" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <span class="material-icons me-2">logout</span> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-outline-success me-2" href="{{ route('auth.login') }}">Iniciar Sesión</a>
                @endauth
            </div>
        </div>
    </nav>

    @auth
        <aside class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">
                            <span class="material-icons me-2">space_dashboard</span> Dashboard
                        </a>
                    </li>
                    @if(auth()->check() && auth()->user()->role->name === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">
                                <span class="material-icons me-2">settings</span> Configuración
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.index') }}">
                            <span class="material-icons me-2">assessment</span> Reportes
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
    @endauth
</header>


    <main class="sidebar__content d-flex flex-column" id="mainContent">
        <section class="col-md-12">
            @if(Session::has('success') || Session::has('warning') || Session::has('error'))
                <div class="alert-container">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! Session::get('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @elseif(Session::has('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {!! Session::get('warning') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @elseif(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! Session::get('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif
                </div>
            @endif
            @yield('content')
        </section>
    </main>

    <footer class="page-footer py-4 text-white text-center" style="background-color: #107033;">
        <h2 class="fw-bold py-2">Certificaciones</h2>
        <div class="d-flex justify-content-center flex-wrap">
            <img src="{{ url('css/imgs/acreditaciones/Logo_ITC.png') }}" class="img-fluid mx-2 rounded-img" alt="Logo ITC">
            <img src="{{ url('css/imgs/acreditaciones/Logo_iso_45001.png') }}" class="img-fluid mx-2 rounded-img" alt="Logo ISO 45001">
            <img src="{{ url('css/imgs/acreditaciones/logo_iso14001.png') }}" class="img-fluid mx-2 rounded-img" alt="Logo ISO 14001">
            <img src="{{ url('css/imgs/acreditaciones/Logo_SAI.png') }}" class="img-fluid mx-2 rounded-img" alt="Logo SAI">
        </div>
        <div class="py-2 fw-bold">
            &copy; {{ date('Y') }} SUSTEMIA
        </div>
        <div class="text-white-50 mt-2">
            <p>Siguenos en nuestras redes sociales:</p>
            <a href="https://www.instagram.com/sustemia" class="text-white me-2" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="mailto:info@sustemia.com" class="text-white me-2"><i class="bi bi-envelope"></i></a>
            <a href="https://www.linkedin.com/in/sustemiallc/" class="text-white me-2" target="_blank"><i class="bi bi-linkedin"></i></a>
        </div>
    </footer>
</div>
</body>
</html>
