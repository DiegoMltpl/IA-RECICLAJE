<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesaje;

class PesajeSeeder extends Seeder
{
    public function run(): void
    {
        $materiales = [
            'plastico',
            'papel',
            'carton',
            'vidrio',
            'metal'
        ];

        for ($i = 0; $i < 200; $i++) {

            $fecha = now()->subDays(rand(0, 30));

            Pesaje::create([
                'user_id' => 1,
                'material' => $materiales[array_rand($materiales)],
                'peso' => rand(1, 50),
                'fecha' => $fecha,
                'created_at' => $fecha,
                'updated_at' => now(),
            ]);

        }
    }
}