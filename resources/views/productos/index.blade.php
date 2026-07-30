@extends('layouts.app')

@section('titulo', 'Productos')
@section('subtitulo', 'Administra tu catálogo de productos')

@push('styles')
<style>
    .prod-thumb {
        width: 42px; height: 42px; border-radius: 11px;
        background: linear-gradient(135deg, var(--bq-rosa-claro), #f7e3ea);
        display: grid; place-items: center; color: var(--bq-vino);
        font-weight: 700; flex-shrink: 0;
    }
    .search-box {
        display: flex; gap: 10px; align-items: center;
        background: var(--bq-surface); border: 1px solid var(--bq-border);
        border-radius: 13px; padding: 6px 6px 6px 16px;
        box-shadow: var(--bq-shadow-sm);
    }
    .search-box i { color: var(--bq-muted); font-size: 1.1rem; }
    .search-box input { border: none; outline: none; background: transparent; flex: 1; font-size: .92rem; padding: 8px 0; }
    .search-box .btn-boutique { padding: 9px 16px; }
    .summary-chips { display: flex; gap: 8px; flex-wrap: wrap; }
    .summary-chip {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 7px 13px; border-radius: 999px; font-size: .82rem; font-weight: 600;
        background: #fff; border: 1px solid var(--bq-border);
    }
    .summary-chip i { font-size: .95rem; }
</style>
@endpush

@section('contenido')

<div class="bq-section-head bq-fade-up">
    <div>
        <h1><i class="bi bi-box-seam text-danger" style="color:var(--bq-rosa)!important;"></i> Productos</h1>
        <p>Gestiona el catálogo completo de tu boutique.</p>
    </div>
    <a href="{{ route('productos.create') }}" class="btn-boutique">
        <i class="bi bi-plus-lg"></i> Nuevo producto
    </a>
</div>

{{-- Buscador + resumen --}}
<form method="GET" action="{{ route('productos.index') }}" class="mb-3 bq-fade-up">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre o SKU...">
        @if (request('q'))
            <a href="{{ route('productos.index') }}" class="icon-btn" title="Limpiar"><i class="bi bi-x-lg"></i></a>
        @endif
        <button class="btn-boutique" type="submit"><i class="bi bi-funnel"></i> Buscar</button>
    </div>
</form>

<div class="summary-chips mb-4 bq-fade-up">
    <span class="summary-chip"><i class="bi bi-box-seam" style="color:var(--bq-vino);"></i> {{ $productos->total() }} productos</span>
    @if (request('q'))
        <span class="summary-chip"><i class="bi bi-funnel" style="color:var(--bq-rosa);"></i> Filtro: "{{ request('q') }}"</span>
    @endif
</div>

<div class="bq-card bq-fade-up overflow-hidden">
    <div class="table-responsive">
        <table class="bq-table">
            <thead>
                <tr>
                    <th>Producto</th>
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
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="prod-thumb">{{ strtoupper(substr($producto->nombre, 0, 1)) }}</div>
                                <div class="fw-semibold">{{ $producto->nombre }}</div>
                            </div>
                        </td>
                        <td><span class="text-muted">{{ $producto->sku ?: '—' }}</span></td>
                        <td>
                            @if ($producto->categoria)
                                <span class="bq-badge neutral"><i class="bi bi-tag"></i> {{ $producto->categoria->nombre }}</span>
                            @else
                                <span class="text-muted">Sin categoría</span>
                            @endif
                        </td>
                        <td class="fw-semibold">$ {{ number_format($producto->precio, 2) }}</td>
                        <td>
                            @if ($producto->stock == 0)
                                <span class="bq-badge bad"><i class="bi bi-x-circle"></i> Agotado</span>
                            @elseif ($producto->stock_bajo)
                                <span class="bq-badge warn"><i class="bi bi-exclamation-triangle"></i> {{ $producto->stock }} u.</span>
                            @else
                                <span class="bq-badge ok"><i class="bi bi-check-circle"></i> {{ $producto->stock }} u.</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('productos.edit', $producto) }}" class="icon-btn" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar el producto «{{ $producto->nombre }}»?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-btn danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="bq-empty">
                                @if (request('q'))
                                    <i class="bi bi-search"></i>
                                    <h5>Sin resultados</h5>
                                    <p>No encontramos productos para «{{ request('q') }}».</p>
                                    <a href="{{ route('productos.index') }}" class="btn-ghost"><i class="bi bi-arrow-counterclockwise"></i> Ver todos</a>
                                @else
                                    <i class="bi bi-box"></i>
                                    <h5>Aún no hay productos</h5>
                                    <p>Empieza agregando tu primer producto al inventario.</p>
                                    <a href="{{ route('productos.create') }}" class="btn-boutique"><i class="bi bi-plus-lg"></i> Crear producto</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($productos->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $productos->links() }}
    </div>
@endif

@endsection
