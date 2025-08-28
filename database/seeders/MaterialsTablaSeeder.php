<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('materials')->insert([
            [
                'nombre' => 'Acrílico 3mm',
                'precio_por_kg' => 25.50,
                'cantidad_stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'MDF 3mm',
                'precio_por_kg' => 15.75,
                'cantidad_stock' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Madera de pino',
                'precio_por_kg' => 30.00,
                'cantidad_stock' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'PVC espumado',
                'precio_por_kg' => 22.40,
                'cantidad_stock' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
