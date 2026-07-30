<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();
        $stockTotal = (int) Producto::sum('stock');
        $valorInventario = (float) Producto::selectRaw('SUM(precio * stock) AS total')->value('total');

        $productosStockBajo = Producto::where('stock', '<', 5)
            ->orderBy('stock')
            ->limit(8)
            ->get();

        // Stock total agrupado por categoría (para el gráfico de barras)
        $stockPorCategoria = Categoria::query()
            ->leftJoin('productos', 'categorias.id', '=', 'productos.categoria_id')
            ->select('categorias.id', 'categorias.nombre')
            ->selectRaw('COALESCE(SUM(productos.stock), 0) as total_stock')
            ->groupBy('categorias.id', 'categorias.nombre')
            ->orderByDesc('total_stock')
            ->limit(6)
            ->get();

        return view('dashboard', compact(
            'totalProductos',
            'totalCategorias',
            'stockTotal',
            'valorInventario',
            'productosStockBajo',
            'stockPorCategoria'
        ));
    }
}
