<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Inventario Boutique')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f7f3f5; }
        .navbar-boutique { background-color: #6d2145; }
        .navbar-boutique .nav-link, .navbar-boutique .navbar-brand { color: #fff !important; }
        .navbar-boutique .nav-link:hover { color: #f3c1d3 !important; }
        .card-stat { border-left: 4px solid #6d2145; }
        .btn-boutique { background-color: #6d2145; border-color: #6d2145; color: #fff; }
        .btn-boutique:hover { background-color: #501731; border-color: #501731; color: #fff; }
    </style>
</head>
<body>

@auth
<nav class="navbar navbar-expand-lg navbar-boutique">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-shop"></i> Inventario Boutique
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categorias.index') }}">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
                </li>
            </ul>
            <span class="navbar-text text-white me-3">
                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </button>
            </form>
        </div>
    </div>
</nav>
@endauth

<div class="container py-4">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('contenido')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
