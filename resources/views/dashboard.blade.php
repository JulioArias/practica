@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
<h2 class="mb-4">Panel principal</h2>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total de productos</div>
                <div class="fs-2 fw-bold">{{ $totalProductos }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Categorías registradas</div>
                <div class="fs-2 fw-bold">{{ $totalCategorias }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Unidades en stock</div>
                <div class="fs-2 fw-bold">{{ $stockTotal }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <i class="bi bi-exclamation-triangle text-warning"></i> Productos con stock bajo (menos de 5 unidades)
    </div>
    <div class="card-body p-0">
        @if ($productosStockBajo->isEmpty())
            <p class="text-muted p-3 mb-0">No hay productos con stock bajo. ¡Todo en orden!</p>
        @else
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productosStockBajo as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->sku }}</td>
                            <td><span class="badge bg-danger">{{ $producto->stock }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
