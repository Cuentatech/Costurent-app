<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disfraz;

class DisfracesSeeder extends Seeder
{
    public function run()
    {
        Disfraz::create([
            'nombre' => 'Vampiro Clásico',
            'descripcion' => 'Disfraz completo de vampiro con capa y colmillos.',
            'categoria_id' => 1,
            'cantidad_total' => 10,
            'cantidad_disponible' => 10,
            'precio' => 150.00,
        ]);

        Disfraz::create([
            'nombre' => 'Bruja Mágica',
            'descripcion' => 'Vestido negro con sombrero puntiagudo y escoba.',
            'categoria_id' => 2,
            'cantidad_total' => 8,
            'cantidad_disponible' => 8,
            'precio' => 120.00,
        ]);
    }
}
