<?php

namespace Database\Seeders;

use App\Models\Piscina;
use Illuminate\Database\Seeder;

class PiscinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Piscina::create([
            "nombre" => "PRUEBAS",
            "litros" => "578",
            "user_id" => 1
        ]);
    }
}
