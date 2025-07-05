<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    public function getDiasRetrasoAttribute()
    {
        if ($this->estado !== 'retrasada' || !$this->fecha_fin) {
            return 0;
        }

        $dias = Carbon::parse($this->fecha_fin)->diffInDays(now(), false);
        return $dias > 0 ? $dias : 0;
    }
    
}