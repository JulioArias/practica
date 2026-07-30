<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Inventario Boutique')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @yield('head')
    <style>
        :root {
            /* Paleta boutique */
            --bq-vino: #6d2145;
            --bq-vino-600: #5a1a38;
            --bq-vino-700: #4a1330;
            --bq-rosa: #d6336c;
            --bq-rosa-claro: #f3c1d3;
            --bq-oro: #c9a227;
            --bq-bg: #f7f3f5;
            --bq-surface: #ffffff;
            --bq-text: #2b1820;
            --bq-muted: #8a7178;
            --bq-border: #ecdede;
            --bq-sidebar-bg: linear-gradient(180deg, #4a1330 0%, #6d2145 55%, #7a264f 100%);
            --bq-shadow: 0 10px 30px -12px rgba(109, 33, 69, 0.25);
            --bq-shadow-sm: 0 4px 14px -8px rgba(109, 33, 69, 0.35);
            --bq-radius: 16px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: var(--bq-bg);
            color: var(--bq-text);
            margin: 0;
            min-height: 100vh;
        }

        @auth
        body { padding-left: 264px; transition: padding .25s ease; }
        @endauth

        /* ===================== SIDEBAR ===================== */
        .bq-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 264px;
            background: var(--bq-sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: transform .25s ease;
            box-shadow: 4px 0 24px rgba(74, 19, 48, 0.25);
        }
        .bq-sidebar-brand {
            padding: 22px 22px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .bq-brand-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--bq-rosa), var(--bq-oro));
            display: grid; place-items: center;
            font-size: 1.3rem;
            box-shadow: 0 6px 16px rgba(214, 51, 108, 0.45);
            flex-shrink: 0;
        }
        .bq-brand-name { font-weight: 800; font-size: 1.05rem; line-height: 1.1; }
        .bq-brand-sub { font-size: .72rem; opacity: .7; letter-spacing: .08em; text-transform: uppercase; }

        .bq-nav { padding: 14px 14px; flex: 1; overflow-y: auto; }
        .bq-nav-label {
            font-size: .68rem; text-transform: uppercase; letter-spacing: .12em;
            opacity: .5; padding: 14px 12px 8px; font-weight: 700;
        }
        .bq-nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; margin-bottom: 4px;
            border-radius: 11px;
            color: rgba(255,255,255,0.82);
            text-decoration: none;
            font-weight: 500; font-size: .92rem;
            transition: all .15s ease;
            position: relative;
        }
        .bq-nav-item i { font-size: 1.15rem; width: 22px; text-align: center; }
        .bq-nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .bq-nav-item.active {
            background: rgba(255,255,255,0.14);
            color: #fff;
            box-shadow: inset 3px 0 0 var(--bq-rosa-claro);
        }

        .bq-sidebar-footer {
            padding: 14px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .bq-user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 10px; border-radius: 12px;
            background: rgba(255,255,255,0.06);
        }
        .bq-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--bq-rosa), var(--bq-vino));
            display: grid; place-items: center;
            font-weight: 700; flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .bq-user-info { min-width: 0; flex: 1; }
        .bq-user-name { font-size: .85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .bq-user-role { font-size: .7rem; opacity: .65; }

        /* ===================== TOPBAR ===================== */
        .bq-topbar {
            position: sticky; top: 0; z-index: 1020;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--bq-border);
            padding: 14px 28px;
            display: flex; align-items: center; gap: 16px;
        }
        .bq-topbar-toggle {
            border: none; background: var(--bq-bg); width: 40px; height: 40px;
            border-radius: 10px; color: var(--bq-vino); font-size: 1.2rem;
            cursor: pointer; display: none;
        }
        .bq-page-title { font-weight: 700; font-size: 1.15rem; margin: 0; flex: 1; }
        .bq-page-title small { display: block; font-weight: 400; font-size: .75rem; color: var(--bq-muted); }

        .bq-topbar-actions { display: flex; align-items: center; gap: 10px; }

        /* ===================== MAIN ===================== */
        .bq-main { padding: 28px; max-width: 1280px; margin: 0 auto; }

        /* ===================== COMPONENTS ===================== */
        .bq-card {
            background: var(--bq-surface);
            border: 1px solid var(--bq-border);
            border-radius: var(--bq-radius);
            box-shadow: var(--bq-shadow-sm);
        }
        .bq-card-pad { padding: 22px; }

        /* Stat cards */
        .stat-card {
            border-radius: var(--bq-radius);
            padding: 22px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: var(--bq-shadow);
            border: none;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 16px 36px -14px rgba(109,33,69,.45); }
        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: 13px;
            background: rgba(255,255,255,0.2);
            display: grid; place-items: center; font-size: 1.4rem;
            backdrop-filter: blur(4px);
        }
        .stat-card .stat-value { font-size: 2rem; font-weight: 800; line-height: 1.1; margin-top: 14px; }
        .stat-card .stat-label { font-size: .82rem; opacity: .9; font-weight: 500; }
        .stat-card .stat-deco {
            position: absolute; right: -18px; top: -18px;
            font-size: 6rem; opacity: .14; transform: rotate(-12deg);
        }
        .stat-vino { background: linear-gradient(135deg, #6d2145, #4a1330); }
        .stat-rosa { background: linear-gradient(135deg, #d6336c, #a61e51); }
        .stat-oro  { background: linear-gradient(135deg, #c9a227, #a3831a); }
        .stat-violet{ background: linear-gradient(135deg, #6d28d9, #4c1d95); }

        /* Botones */
        .btn-boutique {
            background: linear-gradient(135deg, var(--bq-vino), var(--bq-rosa));
            border: none; color: #fff; font-weight: 600;
            padding: 10px 20px; border-radius: 11px;
            box-shadow: var(--bq-shadow-sm);
            transition: all .15s ease;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-boutique:hover { color: #fff; filter: brightness(1.08); transform: translateY(-1px); box-shadow: var(--bq-shadow); }
        .btn-boutique:active { transform: translateY(0); }
        .btn-ghost {
            background: var(--bq-bg); border: 1px solid var(--bq-border);
            color: var(--bq-text); font-weight: 600; border-radius: 11px; padding: 10px 18px;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all .15s ease;
        }
        .btn-ghost:hover { background: #fff; border-color: var(--bq-rosa-claro); color: var(--bq-vino); }

        .icon-btn {
            width: 36px; height: 36px; border-radius: 10px;
            display: inline-grid; place-items: center;
            border: 1px solid var(--bq-border); background: #fff;
            color: var(--bq-muted); transition: all .15s ease;
        }
        .icon-btn:hover { color: var(--bq-vino); border-color: var(--bq-rosa-claro); transform: translateY(-1px); }
        .icon-btn.danger:hover { color: #dc3545; border-color: #f5b3bd; background: #fff5f7; }

        /* Form controls */
        .form-control, .form-select {
            border-radius: 11px; border-color: var(--bq-border);
            padding: 11px 14px; font-size: .92rem;
            transition: all .15s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--bq-rosa); box-shadow: 0 0 0 4px rgba(214,51,108,.12);
        }
        .form-label { font-weight: 600; font-size: .85rem; margin-bottom: 6px; color: var(--bq-text); }
        .form-label .req { color: var(--bq-rosa); }

        /* Badges */
        .bq-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 11px; border-radius: 999px;
            font-size: .78rem; font-weight: 600;
        }
        .bq-badge.ok { background: #e7f6ec; color: #15803d; }
        .bq-badge.warn { background: #fef3c7; color: #b45309; }
        .bq-badge.bad { background: #fde8ec; color: #c81e4a; }
        .bq-badge.neutral { background: #f1e9ec; color: var(--bq-vino); }

        /* Tables */
        .bq-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .bq-table thead th {
            font-size: .72rem; text-transform: uppercase; letter-spacing: .06em;
            color: var(--bq-muted); font-weight: 700;
            padding: 14px 18px; border-bottom: 1px solid var(--bq-border);
            background: #faf6f7; text-align: left;
        }
        .bq-table tbody td { padding: 14px 18px; border-bottom: 1px solid var(--bq-border); vertical-align: middle; }
        .bq-table tbody tr:last-child td { border-bottom: none; }
        .bq-table tbody tr { transition: background .12s ease; }
        .bq-table tbody tr:hover { background: #fdf8fa; }

        /* Alerts */
        .bq-alert {
            border-radius: 13px; padding: 14px 18px; border: 1px solid transparent;
            display: flex; gap: 12px; align-items: flex-start;
            animation: bq-slide-in .3s ease;
        }
        .bq-alert.success { background: #e7f6ec; border-color: #c4e8d0; color: #15803d; }
        .bq-alert.danger { background: #fde8ec; border-color: #f5c3cd; color: #c81e4a; }
        .bq-alert i { font-size: 1.2rem; margin-top: 1px; }

        /* Empty state */
        .bq-empty { text-align: center; padding: 56px 20px; color: var(--bq-muted); }
        .bq-empty i { font-size: 3rem; color: var(--bq-rosa-claro); margin-bottom: 14px; display: block; }
        .bq-empty h5 { color: var(--bq-text); font-weight: 700; margin-bottom: 6px; }

        /* Section header */
        .bq-section-head { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 22px; flex-wrap: wrap; }
        .bq-section-head h1 { font-size: 1.6rem; font-weight: 800; margin: 0; }
        .bq-section-head p { margin: 2px 0 0; color: var(--bq-muted); font-size: .9rem; }

        /* Pagination */
        .pagination { gap: 5px; }
        .page-link {
            border: 1px solid var(--bq-border); color: var(--bq-text);
            border-radius: 10px !important; padding: 8px 13px; font-weight: 600;
        }
        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--bq-vino), var(--bq-rosa));
            border-color: transparent;
        }
        .page-link:hover { color: var(--bq-rosa); }

        @keyframes bq-slide-in { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes bq-fade-up { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .bq-fade-up { animation: bq-fade-up .4s ease both; }
        .bq-fade-up:nth-child(2) { animation-delay: .05s; }
        .bq-fade-up:nth-child(3) { animation-delay: .1s; }
        .bq-fade-up:nth-child(4) { animation-delay: .15s; }

        /* Mobile overlay */
        .bq-overlay {
            position: fixed; inset: 0; background: rgba(74,19,48,.5);
            z-index: 1035; display: none; backdrop-filter: blur(2px);
        }
        .bq-overlay.show { display: block; }

        /* Responsive */
        @media (max-width: 991.98px) {
            body { padding-left: 0 !important; }
            .bq-sidebar { transform: translateX(-100%); }
            .bq-sidebar.show { transform: translateX(0); }
            .bq-topbar-toggle { display: grid; place-items: center; }
            .bq-main { padding: 18px; }
        }
    </style>
    @stack('styles')
</head>
<body>

@auth
<!-- Sidebar -->
<aside class="bq-sidebar" id="bqSidebar">
    <div class="bq-sidebar-brand">
        <div class="bq-brand-icon"><i class="bi bi-bag-heart-fill"></i></div>
        <div>
            <div class="bq-brand-name">Inventario</div>
            <div class="bq-brand-sub">Boutique</div>
        </div>
    </div>

    <nav class="bq-nav">
        <div class="bq-nav-label">Menú</div>
        @php
            $routeActual = request()->route() ? request()->route()->getName() : '';
            $esActivo = fn($n) => $routeActual === $n || str_starts_with($routeActual, $n.'.');
        @endphp
        <a href="{{ route('dashboard') }}" class="bq-nav-item {{ $esActivo('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="{{ route('productos.index') }}" class="bq-nav-item {{ $esActivo('productos') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Productos
        </a>
        <a href="{{ route('categorias.index') }}" class="bq-nav-item {{ $esActivo('categorias') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Categorías
        </a>

        <div class="bq-nav-label">Cuenta</div>
        <form action="{{ route('logout') }}" method="POST" id="logoutForm">@csrf</form>
        <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;" class="bq-nav-item">
            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </a>
    </nav>

    <div class="bq-sidebar-footer">
        <div class="bq-user-card">
            <div class="bq-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="bq-user-info">
                <div class="bq-user-name">{{ auth()->user()->name }}</div>
                <div class="bq-user-role">Administrador</div>
            </div>
        </div>
    </div>
</aside>
<div class="bq-overlay" id="bqOverlay"></div>
@endauth

<!-- Topbar (solo autenticado) -->
@auth
<header class="bq-topbar">
    <button class="bq-topbar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <h1 class="bq-page-title">
        @yield('titulo', 'Inventario Boutique')
        <small>@yield('subtitulo', 'Gestión de inventario de boutique')</small>
    </h1>
    <div class="bq-topbar-actions">
        <a href="{{ route('dashboard') }}" class="icon-btn" title="Dashboard"><i class="bi bi-house"></i></a>
        <form action="{{ route('logout') }}" method="POST" class="d-none d-sm-block">
            @csrf
            <button class="btn-boutique" type="submit"><i class="bi bi-box-arrow-right"></i> Salir</button>
        </form>
    </div>
</header>
@endauth

<div class="@auth bq-main @endauth">
    @auth
    @if (session('success'))
        <div class="bq-alert success mb-4 bq-fade-up" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if ($errors->any())
        <div class="bq-alert danger mb-4 bq-fade-up" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif
    @endauth

    @yield('contenido')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('bqSidebar').classList.toggle('show');
        document.getElementById('bqOverlay').classList.toggle('show');
    }
    // Cerrar sidebar al hacer clic fuera o navegar (móvil)
    document.getElementById('bqOverlay')?.addEventListener('click', () => {
        document.getElementById('bqSidebar').classList.remove('show');
        document.getElementById('bqOverlay').classList.remove('show');
    });
    document.querySelectorAll('.bq-nav-item').forEach(a => {
        a.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                document.getElementById('bqSidebar').classList.remove('show');
                document.getElementById('bqOverlay').classList.remove('show');
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>
