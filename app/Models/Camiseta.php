<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camiseta extends Model
{
    protected $fillable = [
        'titulo',
        'club',
        'pais',
        'tipo',
        'color',
        'precio',
        'precio_oferta',
        'detalles',
        'codigo_producto',
        'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tallas()
    {
        return $this->belongsToMany(Talla::class, 'camiseta_tallas');
    }
}
