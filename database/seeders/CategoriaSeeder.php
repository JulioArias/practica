<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Vestidos', 'descripcion' => 'Vestidos casuales y de fiesta'],
            ['nombre' => 'Blusas', 'descripcion' => 'Blusas y tops'],
            ['nombre' => 'Pantalones', 'descripcion' => 'Pantalones y jeans'],
            ['nombre' => 'Accesorios', 'descripcion' => 'Bolsos, bisutería y complementos'],
            ['nombre' => 'Calzado', 'descripcion' => 'Zapatos, sandalias y tacones'],
        ];

        foreach ($categorias as $categoria) {
            $cat = Categoria::create($categoria);

            Producto::create([
                'nombre' => $cat->nombre.' - Modelo Básico',
                'descripcion' => 'Producto de ejemplo generado automáticamente.',
                'sku' => strtoupper(substr($cat->nombre, 0, 3)).'-001',
                'precio' => rand(10, 80) + 0.99,
                'stock' => rand(0, 30),
                'categoria_id' => $cat->id,
            ]);
        }
    }
}
