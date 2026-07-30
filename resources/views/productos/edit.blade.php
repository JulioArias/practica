@extends('layouts.app')

@section('titulo', 'Editar producto')
@section('subtitulo', 'Modifica la información del producto')

@section('contenido')

<div class="bq-section-head bq-fade-up">
    <div>
        <h1><i class="bi bi-pencil-square" style="color:var(--bq-rosa);"></i> Editar producto</h1>
        <p>Editando: <strong>{{ $producto->nombre }}</strong></p>
    </div>
    <a href="{{ route('productos.index') }}" class="btn-ghost"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <form method="POST" action="{{ route('productos.update', $producto) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre <span class="req">*</span></label>
                            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="form-control" required autofocus>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU (código)</label>
                            <input type="text" name="sku" value="{{ old('sku', $producto->sku) }}" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Precio <span class="req">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:11px 0 0 11px;border-color:var(--bq-border);background:#faf6f7;">$</span>
                                <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $producto->precio) }}" class="form-control" style="border-radius:0 11px 11px 0;" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock <span class="req">*</span></label>
                            <input type="number" min="0" name="stock" value="{{ old('stock', $producto->stock) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-select">
                                <option value="">Sin categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $producto->categoria_id) == $categoria->id)>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn-boutique"><i class="bi bi-check-lg"></i> Actualizar producto</button>
                        <a href="{{ route('productos.index') }}" class="btn-ghost">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bq-card bq-fade-up">
            <div class="bq-card-pad">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle" style="color:var(--bq-rosa);"></i> Estado actual</h6>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Stock actual</span>
                    @if ($producto->stock == 0)
                        <span class="bq-badge bad">Agotado</span>
                    @elseif ($producto->stock_bajo)
                        <span class="bq-badge warn">{{ $producto->stock }} u.</span>
                    @else
                        <span class="bq-badge ok">{{ $producto->stock }} u.</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between"><span class="text-muted">Valor en stock</span><strong>$ {{ number_format($producto->precio * $producto->stock, 2) }}</strong></div>
            </div>
        </div>
    </div>
</div>

@endsection
