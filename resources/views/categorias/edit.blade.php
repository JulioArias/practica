@extends('layouts.app')

@section('titulo', 'Editar categoría')
@section('subtitulo', 'Modifica los datos de la categoría')

@section('contenido')

<div class="bq-section-head bq-fade-up">
    <div>
        <h1><i class="bi bi-pencil-square" style="color:var(--bq-rosa);"></i> Editar categoría</h1>
        <p>Editando: <strong>{{ $categoria->nombre }}</strong></p>
    </div>
    <a href="{{ route('categorias.index') }}" class="btn-ghost"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <form method="POST" action="{{ route('categorias.update', $categoria) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="req">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn-boutique"><i class="bi bi-check-lg"></i> Actualizar categoría</button>
                        <a href="{{ route('categorias.index') }}" class="btn-ghost">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle" style="color:var(--bq-rosa);"></i> Resumen</h6>
                <div class="d-flex justify-content-between"><span class="text-muted">Productos asociados</span><strong>{{ $categoria->productos()->count() }}</strong></div>
            </div>
        </div>
    </div>
</div>

@endsection
