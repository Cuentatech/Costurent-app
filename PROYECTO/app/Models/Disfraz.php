<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disfraz extends Model
{
    protected $table = 'disfraces';

    protected $fillable = [
        'nombre', 'descripcion', 'categoria_id', 
        'cantidad_total', 'cantidad_disponible', 'precio'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function alquileres()
    {
        return $this->hasMany(Alquiler::class, 'disfraz_id');
    }
}


