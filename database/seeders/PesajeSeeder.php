<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesaje;
use App\Models\User;

class PesajeSeeder extends Seeder
{
   public function run()
{
    $user = User::first();

    if (!$user) {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('12345678'),
        ]);
    }

    $materiales = ['plastico', 'vidrio', 'metal', 'carton'];

    for ($i = 0; $i < 200; $i++) {
        Pesaje::create([
            'user_id' => $user->id,
            'material' => $materiales[array_rand($materiales)],
            'peso' => rand(1, 20),
            'fecha' => now()->subDays(rand(0, 30)),
        ]);
    }
}
}