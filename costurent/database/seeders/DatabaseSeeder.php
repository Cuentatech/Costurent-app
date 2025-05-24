<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        public function run()
    {
        $this->call(UsuariosSeeder::class);
        $this->call(CategoriasSeeder::class);
        $this->call(DisfracesSeeder::class);
        $this->call(AlquileresSeeder::class);
    }

}
