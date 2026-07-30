@extends('layouts.app')

@section('titulo', 'Crear cuenta')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body p-4">
                <h3 class="text-center mb-4" style="color:#6d2145;">
                    <i class="bi bi-shop"></i><br>Crear cuenta
                </h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-boutique w-100">Registrarme</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
