@extends('layouts.app')

@section('titulo', 'Categorías')
@section('subtitulo', 'Organiza tus productos por grupos')

@push('styles')
<style>
    .cat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        background: linear-gradient(135deg, var(--bq-rosa-claro), #f7e3ea);
        display: grid; place-items: center; color: var(--bq-vino); font-size: 1.3rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('contenido')

<div class="bq-section-head bq-fade-up">
    <div>
        <h1><i class="bi bi-tags" style="color:var(--bq-rosa);"></i> Categorías</h1>
        <p>Agrupa y clasifica tus productos.</p>
    </div>
    <a href="{{ route('categorias.create') }}" class="btn-boutique">
        <i class="bi bi-plus-lg"></i> Nueva categoría
    </a>
</div>

<div class="bq-card bq-fade-up overflow-hidden">
    <div class="table-responsive">
        <table class="bq-table">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Productos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="cat-icon"><i class="bi bi-folder2"></i></div>
                                <div class="fw-semibold">{{ $categoria->nombre }}</div>
                            </div>
                        </td>
                        <td><span class="text-muted">{{ $categoria->descripcion ?: '—' }}</span></td>
                        <td><span class="bq-badge neutral"><i class="bi bi-box"></i> {{ $categoria->productos_count }}</span></td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('categorias.edit', $categoria) }}" class="icon-btn" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar la categoría «{{ $categoria->nombre }}»?');">
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
                        <td colspan="4">
                            <div class="bq-empty">
                                <i class="bi bi-tags"></i>
                                <h5>No hay categorías</h5>
                                <p>Crea tu primera categoría para organizar tus productos.</p>
                                <a href="{{ route('categorias.create') }}" class="btn-boutique"><i class="bi bi-plus-lg"></i> Crear categoría</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($categorias->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $categorias->links() }}
    </div>
@endif

@endsection
