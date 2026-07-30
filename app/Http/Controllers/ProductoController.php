<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos (con búsqueda opcional).
     */
    public function index(Request $request)
    {
        $query = Producto::with('categoria');

        if ($busqueda = $request->get('q')) {
            $query->where('nombre', 'like', "%{$busqueda}%")
                ->orWhere('sku', 'like', "%{$busqueda}%");
        }

        $productos = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('productos.index', compact('productos'));
    }

    /**
     * Mostrar el formulario de creación.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo producto.
     */
    public function store(Request $request)
    {
        $data = $this->validarProducto($request);

        Producto::create($data);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualizar un producto existente.
     */
    public function update(Request $request, Producto $producto)
    {
        $data = $this->validarProducto($request, $producto->id);

        $producto->update($data);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Reglas de validación compartidas entre store y update.
     */
    private function validarProducto(Request $request, ?int $ignorarId = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:100', 'unique:productos,sku,'.$ignorarId],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['nullable', 'exists:categorias,id'],
        ]);
    }
}
