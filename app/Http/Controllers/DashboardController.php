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
        $stockTotal = Producto::sum('stock');
        $productosStockBajo = Producto::where('stock', '<', 5)->orderBy('stock')->get();

        return view('dashboard', compact(
            'totalProductos',
            'totalCategorias',
            'stockTotal',
            'productosStockBajo'
        ));
    }
}
