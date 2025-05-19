<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run()
{
    \App\Models\Usuario::create([
        'nombre' => 'Juan',
        'apellido' => 'Perez',
        'correo' => 'juan@example.com',
        'clave' => Hash::make('123456789'),  // Usa Hash::make
        'rol' => 'administrador',
    ]);
}
}
