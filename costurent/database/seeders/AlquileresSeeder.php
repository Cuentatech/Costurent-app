<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alquiler;
use App\Models\Usuario;
use App\Models\Disfraz;
use Carbon\Carbon;

class AlquileresSeeder extends Seeder
{
    public function run()
    {
        // Supongamos que tienes usuarios y disfraces ya creados
        $cliente = Usuario::where('rol', 'cliente')->first();
        $disfraz = Disfraz::first();

        if ($cliente && $disfraz) {
            Alquiler::create([
                'usuario_id' => 2,
                'disfraz_id' => 2,
                'fecha_inicio' => '2025-05-19 00:50:58',
                'fecha_fin' => '2025-05-29 00:50:58',
                'estado' => 'activa',
                'cantidad' => 1,
                'total' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
