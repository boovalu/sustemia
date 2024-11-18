<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') :: PANEL DE ADMINISTRACIÓN</title>
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="icon" type="image/png" href="{{ url('css/imgs/favicon-32x32.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/styles.css') }}">
    <link rel="stylesheet" href="{{ url('css/admin.css') }}"> <!-- Estilos específicos para el admin -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ url('css/imgs/resource/logoOficial_sustemia.png') }}" width="95" height="60" class="img-fluid" alt="Logo">
                </a>
                <a class="navbar-brand nav-link" href="{{ route('admin.index') }}">Panel de Administración</a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <a href="{{ url('/') }}" class="offcanvas-title text-white" id="offcanvasNavbarLabel">Sustemia</a>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.index') }}">
                                    <i class="bi bi-graph-up"></i> Dashboard de Reportes
                                </a>
                            </li>
                            @auth
<li class="nav-item ms-auto d-flex align-items-center">
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
</li>
@endauth


                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container p-2">
            @if (\Session::has('success'))
            <div class="alert alert-success mb-2">{!! \Session::get('success') !!}</div>
            @elseif (\Session::has('warning'))
            <div class="alert alert-warning mb-2">{!! \Session::get('warning') !!}</div>
            @endif
            @yield('content')
        </main>

        <footer class="footer text-center border-top">
            <span>&copy; Sustemia {{ date('Y') }}</span>
        </footer>
    </div>
</body>

</html>
