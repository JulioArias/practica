@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body p-4">
                <h3 class="text-center mb-4" style="color:#6d2145;">
                    <i class="bi bi-shop"></i><br>Inventario Boutique
                </h3>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>

                    <button type="submit" class="btn btn-boutique w-100">Ingresar</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
