<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        Usuario::create([
            'nombre' => 'Admin',
            'apellido' => 'Principal',
            'correo' => 'admin@gmail.com',
            'clave' => Hash::make('admin123'), 
            'rol' => 'administrador',
            'imagen' => 'default-admin.png', // Imagen por defecto para el administrador
        ]);

        Usuario::create([
            'nombre' => 'Cliente',
            'apellido' => 'Señor',
            'correo' => 'cliente@gmail.com',
            'clave' => Hash::make('cliente123'),
            'rol' => 'cliente',
            'imagen' => 'default.png', // Imagen por defecto para el cliente
        ]);
    }
}
