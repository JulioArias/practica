@extends('layouts.app')

@section('titulo', 'Editar categoría')

@section('contenido')
<h2 class="mb-4">Editar categoría</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('categorias.update', $categoria) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            </div>

            <button type="submit" class="btn btn-boutique">Actualizar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
