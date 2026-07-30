<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'sku',
        'precio',
        'stock',
        'categoria_id',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    /**
     * Categoría a la que pertenece el producto.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Accesor: indica si el stock está bajo (menos de 5 unidades).
     */
    public function getStockBajoAttribute(): bool
    {
        return $this->stock < 5;
    }
}
