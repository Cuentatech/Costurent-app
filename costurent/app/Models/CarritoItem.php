<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $table = 'carrito_items';

    protected $fillable = [
        'usuario_id', 'disfraz_id', 'cantidad'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function disfraz()
    {
        return $this->belongsTo(Disfraz::class, 'disfraz_id');
    }
}
