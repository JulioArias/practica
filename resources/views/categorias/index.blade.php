@extends('layouts.app')

@section('titulo', 'Categorías')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Categorías</h2>
    <a href="{{ route('categorias.create') }}" class="btn btn-boutique">
        <i class="bi bi-plus-lg"></i> Nueva categoría
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th># Productos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->descripcion ?? '—' }}</td>
                        <td><span class="badge bg-secondary">{{ $categoria->productos_count }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta categoría?');">
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
                        <td colspan="4" class="text-center text-muted py-4">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $categorias->links() }}
</div>
@endsection
