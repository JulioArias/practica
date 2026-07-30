@extends('layouts.app')

@section('titulo', 'Productos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Productos</h2>
    <a href="{{ route('productos.create') }}" class="btn btn-boutique">
        <i class="bi bi-plus-lg"></i> Nuevo producto
    </a>
</div>

<form method="GET" action="{{ route('productos.index') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por nombre o SKU...">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Buscar</button>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->sku ?? '—' }}</td>
                        <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>
                            @if ($producto->stock_bajo)
                                <span class="badge bg-danger">{{ $producto->stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $producto->stock }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $productos->links() }}
</div>
@endsection
