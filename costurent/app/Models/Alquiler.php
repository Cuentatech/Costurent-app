<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    protected $table = 'alquileres';

    protected $fillable = [
        'usuario_id', 'disfraz_id', 'cantidad', 'fecha_inicio',
        'fecha_fin', 'estado', 'total', 'dias_retraso', 'monto_sancion'
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
