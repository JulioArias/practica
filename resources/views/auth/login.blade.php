@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@push('styles')
<style>
    body { background: var(--bq-bg); }
    .auth-wrap {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr;
    }
    @media (min-width: 992px) { .auth-wrap { grid-template-columns: 1.05fr 1fr; } }

    /* Panel izquierdo (branding) */
    .auth-brand {
        background: linear-gradient(135deg, #4a1330 0%, #6d2145 50%, #d6336c 100%);
        color: #fff;
        display: none;
        flex-direction: column;
        justify-content: center;
        padding: 56px 56px;
        position: relative;
        overflow: hidden;
    }
    @media (min-width: 992px) { .auth-brand { display: flex; } }
    .auth-brand::before {
        content: ""; position: absolute; width: 380px; height: 380px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%);
        top: -120px; right: -120px;
    }
    .auth-brand::after {
        content: ""; position: absolute; width: 260px; height: 260px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,162,39,.18), transparent 70%);
        bottom: -80px; left: -80px;
    }
    .auth-brand .brand-logo {
        width: 62px; height: 62px; border-radius: 17px;
        background: rgba(255,255,255,.16);
        display: grid; place-items: center; font-size: 1.9rem;
        backdrop-filter: blur(6px); margin-bottom: 26px;
        box-shadow: 0 10px 28px rgba(0,0,0,.18);
    }
    .auth-brand h1 { font-weight: 800; font-size: 2.4rem; line-height: 1.15; margin-bottom: 16px; }
    .auth-brand p { font-size: 1.05rem; opacity: .9; max-width: 420px; }
    .auth-features { list-style: none; padding: 0; margin: 32px 0 0; display: grid; gap: 14px; }
    .auth-features li { display: flex; align-items: center; gap: 12px; font-weight: 500; }
    .auth-features i {
        width: 34px; height: 34px; border-radius: 10px;
        background: rgba(255,255,255,.15); display: grid; place-items: center; font-size: 1rem;
    }

    /* Panel derecho (formulario) */
    .auth-form-side {
        display: flex; align-items: center; justify-content: center;
        padding: 40px 24px;
    }
    .auth-card { width: 100%; max-width: 420px; }
    .auth-card .mobile-logo {
        display: grid; place-items: center; margin-bottom: 18px;
    }
    @media (min-width: 992px) { .auth-card .mobile-logo { display: none; } }
    .auth-card h2 { font-weight: 800; font-size: 1.7rem; margin-bottom: 6px; }
    .auth-card .sub { color: var(--bq-muted); margin-bottom: 26px; }
    .auth-card .input-icon { position: relative; }
    .auth-card .input-icon i {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: var(--bq-muted);
    }
    .auth-card .input-icon .form-control { padding-left: 42px; }
    .toggle-pass {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        border: none; background: none; color: var(--bq-muted); cursor: pointer; font-size: 1.05rem;
    }
    .auth-divider { text-align: center; margin: 6px 0; color: var(--bq-muted); font-size: .82rem; }
</style>
@endpush

@section('contenido')
<div class="auth-wrap">
    {{-- Panel de branding --}}
    <div class="auth-brand">
        <div class="brand-logo"><i class="bi bi-bag-heart-fill"></i></div>
        <h1>Tus,<br>bien organizada.</h1>
        <p>Controla productos y de todo, categorías y stock desde un solo lugar. Diseñado para mantener tu inventario siempre al día.</p>
        <ul class="auth-features">
            <li><i class="bi bi-box-seam"></i> Gestión completa de productos</li>
            <li><i class="bi bi-bell"></i> Alertas de stock bajo automático</li>
            <li><i class="bi bi-bar-chart"></i> Métricas en tiempo real</li>
        </ul>
    </div>

    {{-- Panel del formulario --}}
    <div class="auth-form-side">
        <div class="auth-card bq-fade-up">
            <div class="mobile-logo">
                <div class="bq-brand-icon" style="width:54px;height:54px;font-size:1.6rem;"><i class="bi bi-bag-heart-fill"></i></div>
            </div>
            <h2>Bienvenida de nuevo 👋</h2>
            <p class="sub">Ingresa tus datos para acceder al panel.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="tucorreo@boutique.com" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="passwordField" class="form-control" placeholder="••••••••" required>
                        <button type="button" class="toggle-pass" onclick="togglePass('passwordField', this)"><i class="bi bi-eye"></i></button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                </div>

                <button type="submit" class="btn-boutique w-100 justify-content-center" style="padding:13px;">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                </button>
            </form>

            <p class="auth-divider">¿No tienes cuenta?</p>
            <a href="{{ route('register') }}" class="btn-ghost w-100 justify-content-center">
                <i class="bi bi-person-plus"></i> Crear cuenta nueva
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePass(id, btn) {
        const f = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (f.type === 'password') { f.type = 'text'; icon.classList.replace('bi-eye','bi-eye-slash'); }
        else { f.type = 'password'; icon.classList.replace('bi-eye-slash','bi-eye'); }
    }
</script>
@endpush
@endsection
