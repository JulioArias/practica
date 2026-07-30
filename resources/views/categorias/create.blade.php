@extends('layouts.app')

@section('titulo', 'Nueva categoría')
@section('subtitulo', 'Crea un grupo para organizar productos')

@section('contenido')

<div class="bq-section-head bq-fade-up">
    <div>
        <h1><i class="bi bi-plus-square" style="color:var(--bq-rosa);"></i> Nueva categoría</h1>
        <p>Las categorías te ayudan a clasificar tus productos.</p>
    </div>
    <a href="{{ route('categorias.index') }}" class="btn-ghost"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <form method="POST" action="{{ route('categorias.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="req">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" placeholder="Ej. Camisas" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción breve de la categoría...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn-boutique"><i class="bi bi-check-lg"></i> Guardar categoría</button>
                        <a href="{{ route('categorias.index') }}" class="btn-ghost">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <h6 class="fw-bold mb-3"><i class="bi bi-lightbulb" style="color:var(--bq-oro);"></i> Ejemplos de categorías</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="bq-badge neutral"><i class="bi bi-tag"></i> Ropa</span>
                    <span class="bq-badge neutral"><i class="bi bi-tag"></i> Accesorios</span>
                    <span class="bq-badge neutral"><i class="bi bi-tag"></i> Calzado</span>
                    <span class="bq-badge neutral"><i class="bi bi-tag"></i> Joyería</span>
                    <span class="bq-badge neutral"><i class="bi bi-tag"></i> Temporada</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
