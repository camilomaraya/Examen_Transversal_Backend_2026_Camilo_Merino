<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre_comercial',
        'rut',
        'direccion',
        'tipo',
        'contacto_nombre',
        'contacto_email',
        'porcentaje_oferta',
    ];

    public function camisetas()
    {
        return $this->hasMany(Camiseta::class);
    }
}
