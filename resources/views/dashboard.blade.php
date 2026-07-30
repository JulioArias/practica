@extends('layouts.app')

@section('titulo', 'Dashboard')
@section('subtitulo', 'Resumen general de tu inventario')

@push('styles')
<style>
    .hero-banner {
        background: linear-gradient(120deg, #4a1330 0%, #6d2145 45%, #d6336c 100%);
        border-radius: 20px;
        padding: 30px 32px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 40px -16px rgba(109,33,69,.5);
        margin-bottom: 26px;
    }
    .hero-banner::after {
        content: ""; position: absolute; right: -60px; top: -60px;
        width: 260px; height: 260px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,.15), transparent 70%);
    }
    .hero-banner h2 { font-weight: 800; margin-bottom: 6px; font-size: 1.7rem; }
    .hero-banner p { opacity: .9; margin-bottom: 0; max-width: 540px; }
    .hero-banner .hero-cta { margin-top: 18px; display: flex; gap: 10px; flex-wrap: wrap; }
    .hero-banner .btn-glass {
        background: rgba(255,255,255,.18); color: #fff; border: 1px solid rgba(255,255,255,.3);
        backdrop-filter: blur(6px); font-weight: 600; padding: 9px 18px; border-radius: 11px;
        display: inline-flex; align-items: center; gap: 8px; transition: all .15s ease;
    }
    .hero-banner .btn-glass:hover { background: rgba(255,255,255,.28); color: #fff; transform: translateY(-1px); }
    .hero-banner .btn-glass.solid { background: #fff; color: var(--bq-vino); }
    .hero-banner .btn-glass.solid:hover { background: #f3c1d3; }

    .panel-head { display: flex; align-items: center; gap: 10px; padding: 18px 22px; border-bottom: 1px solid var(--bq-border); }
    .panel-head h5 { margin: 0; font-weight: 700; font-size: 1.02rem; }
    .panel-head .dot { width: 10px; height: 10px; border-radius: 50%; background: var(--bq-rosa); }

    .bar-row { display: flex; align-items: center; gap: 14px; padding: 12px 0; }
    .bar-row .bar-label { flex: 0 0 130px; font-weight: 600; font-size: .88rem; }
    .bar-track { flex: 1; height: 10px; background: #f1e9ec; border-radius: 999px; overflow: hidden; }
    .bar-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--bq-vino), var(--bq-rosa)); transition: width .6s ease; }
    .bar-row .bar-val { flex: 0 0 56px; text-align: right; font-weight: 700; color: var(--bq-vino); }
</style>
@endpush

@section('contenido')

{{-- Banner de bienvenida --}}
<div class="hero-banner bq-fade-up">
    <h2><i class="bi bi-bag-heart-fill"></i> ¡Hola, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
    <p>Este es el resumen de tu boutique hoy. {{ $totalProductos > 0 ? 'Mantén tu inventario al día.' : 'Empieza creando tu primer producto.' }}</p>
    <div class="hero-cta">
        <a href="{{ route('productos.create') }}" class="btn-glass solid"><i class="bi bi-plus-lg"></i> Nuevo producto</a>
        <a href="{{ route('categorias.create') }}" class="btn-glass"><i class="bi bi-tags"></i> Nueva categoría</a>
    </div>
</div>

{{-- Tarjetas de estadísticas --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-vino bq-fade-up h-100">
            <span class="stat-deco"><i class="bi bi-box-seam"></i></span>
            <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
            <div class="stat-value">{{ $totalProductos }}</div>
            <div class="stat-label">Total de productos</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-rosa bq-fade-up h-100">
            <span class="stat-deco"><i class="bi bi-tags"></i></span>
            <div class="stat-icon"><i class="bi bi-tags"></i></div>
            <div class="stat-value">{{ $totalCategorias }}</div>
            <div class="stat-label">Categorías registradas</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-oro bq-fade-up h-100">
            <span class="stat-deco"><i class="bi bi-stack"></i></span>
            <div class="stat-icon"><i class="bi bi-stack"></i></div>
            <div class="stat-value">{{ $stockTotal }}</div>
            <div class="stat-label">Unidades en stock</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-violet bq-fade-up h-100">
            <span class="stat-deco"><i class="bi bi-cash-coin"></i></span>
            <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-value">$ {{ number_format($valorInventario, 2) }}</div>
            <div class="stat-label">Valor del inventario</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Stock por categoría (gráfico de barras) --}}
    <div class="col-lg-7">
        <div class="bq-card bq-fade-up h-100">
            <div class="panel-head">
                <span class="dot"></span>
                <h5>Stock por categoría</h5>
            </div>
            <div class="bq-card-pad">
                @if ($stockPorCategoria->isEmpty())
                    <div class="bq-empty" style="padding:32px 20px;">
                        <i class="bi bi-bar-chart"></i>
                        <p class="mb-0">Crea categorías y productos para ver el gráfico.</p>
                    </div>
                @else
                    @php $maxStock = $stockPorCategoria->max('total_stock') ?: 1; @endphp
                    @foreach ($stockPorCategoria as $cat)
                        <div class="bar-row">
                            <div class="bar-label">{{ $cat->nombre }}</div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ ($cat->total_stock / $maxStock) * 100 }}%"></div>
                            </div>
                            <div class="bar-val">{{ $cat->total_stock }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Alertas de stock bajo --}}
    <div class="col-lg-5">
        <div class="bq-card bq-fade-up h-100">
            <div class="panel-head" style="background:#fff5f7;">
                <span class="dot" style="background:#dc3545;"></span>
                <h5>Alertas de stock bajo</h5>
                @if ($productosStockBajo->isNotEmpty())
                    <span class="bq-badge bad ms-auto"><i class="bi bi-exclamation-triangle"></i> {{ $productosStockBajo->count() }}</span>
                @endif
            </div>
            <div class="bq-card-pad">
                @if ($productosStockBajo->isEmpty())
                    <div class="bq-empty" style="padding:32px 20px;">
                        <i class="bi bi-check-circle"></i>
                        <h5>¡Todo en orden!</h5>
                        <p class="mb-0">No hay productos con stock bajo.</p>
                    </div>
                @else
                    @foreach ($productosStockBajo as $producto)
                        <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px solid var(--bq-border);">
                            <div class="icon-btn danger" style="width:40px;height:40px;"><i class="bi bi-exclamation-circle"></i></div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-truncate">{{ $producto->nombre }}</div>
                                <div class="small text-muted">{{ $producto->sku ?? 'Sin SKU' }}</div>
                            </div>
                            <span class="bq-badge {{ $producto->stock == 0 ? 'bad' : 'warn' }}">
                                {{ $producto->stock == 0 ? 'Agotado' : $producto->stock . ' u.' }}
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
