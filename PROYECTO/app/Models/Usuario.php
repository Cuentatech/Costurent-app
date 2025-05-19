<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'clave',
        'telefono',
        'rol',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    // Dentro de App\Models\Usuario.php
    public function getAuthPassword()
{
    return $this->clave;
}


}
