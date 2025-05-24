<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Terror', 'descripcion' => 'Disfraces de terror', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Princesas', 'descripcion' => 'Disfraces de princesas', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Comedia', 'descripcion' => 'Disfraces cómicos', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
