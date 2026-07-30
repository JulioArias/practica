@extends('layouts.app')

@section('titulo', 'Nueva categoría')

@section('contenido')
<h2 class="mb-4">Nueva categoría</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('categorias.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
            </div>

            <button type="submit" class="btn btn-boutique">Guardar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
