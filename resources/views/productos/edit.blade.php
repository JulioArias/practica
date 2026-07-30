@extends('layouts.app')

@section('titulo', 'Editar producto')

@section('contenido')
<h2 class="mb-4">Editar producto</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('productos.update', $producto) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
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
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $producto->precio) }}" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Stock</label>
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

            <button type="submit" class="btn btn-boutique">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
