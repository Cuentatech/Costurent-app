<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Alquiler extends Model
{
    protected $table = 'alquileres';

    protected $fillable = [
        'usuario_id',
        'disfraz_id',
        'precio',
        'cantidad',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'dias_retraso',
        'monto_sancion',
        'total' // ✅ monto_total calculado y guardado
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function disfraz()
    {
        return $this->belongsTo(Disfraz::class, 'disfraz_id');
    }
    public function getPrecioAttribute()
    {
        return $this->disfraz ? $this->disfraz->precio : 0;
    }


    public function getDiasRetrasoAttribute()
    {
        if (!$this->fecha_fin || $this->estado === 'finalizada') return 0;

        $fin = Carbon::parse($this->fecha_fin)->addDay()->startOfDay();
        $hoy = Carbon::now()->startOfDay();

        return $hoy->gt($fin) ? $fin->diffInDays($hoy) : 0;
    }

    public function getMontoSancionAttribute()
    {
        return $this->dias_retraso * 10;
    }
    public function getMontoBaseAttribute()
    {
        $dias = Carbon::parse($this->fecha_inicio)->diffInDays(Carbon::parse($this->fecha_fin)) + 1;
        return $dias * $this->precio * $this->cantidad;
    }

    // 💰 Monto total incluyendo sanción
    public function getMontoTotalAttribute()
    {
        return $this->monto_base + $this->monto_sancion;
    }

}