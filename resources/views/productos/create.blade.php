@extends('layouts.app')

@section('titulo', 'Nuevo producto')
@section('subtitulo', 'Agrega un producto al catálogo')

@section('contenido')

<div class="bq-section-head bq-fade-up">
    <div>
        <h1><i class="bi bi-plus-square" style="color:var(--bq-rosa);"></i> Nuevo producto</h1>
        <p>Completa la información del producto.</p>
    </div>
    <a href="{{ route('productos.index') }}" class="btn-ghost"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <form method="POST" action="{{ route('productos.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre <span class="req">*</span></label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" placeholder="Ej. Blusa de seda" required autofocus>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU (código)</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" class="form-control" placeholder="Ej. BLU-001">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Detalles del producto...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Precio <span class="req">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:11px 0 0 11px;border-color:var(--bq-border);background:#faf6f7;">$</span>
                                <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio') }}" class="form-control" style="border-radius:0 11px 11px 0;" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock <span class="req">*</span></label>
                            <input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-select">
                                <option value="">Sin categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn-boutique"><i class="bi bi-check-lg"></i> Guardar producto</button>
                        <a href="{{ route('productos.index') }}" class="btn-ghost">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Panel de ayuda --}}
    <div class="col-lg-4">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle" style="color:var(--bq-rosa);"></i> Consejos</h6>
                <ul class="mb-0 ps-3 small" style="line-height:1.7;color:var(--bq-muted);">
                    <li>Usa un <strong>SKU único</strong> para identificar cada producto.</li>
                    <li>El sistema alertará cuando el stock sea <strong>menor a 5</strong>.</li>
                    <li>Asigna una categoría para organizar mejor el catálogo.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
