<?php

namespace Database\Seeders;

use App\Models\AeronaveUnidades;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AeronaveUnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº4', 'codigos' => 'G-4'],
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº5', 'codigos' => 'G-5'],
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº6', 'codigos' => 'G-6'],
            ['unidad' => 'GRUPO AÉREO DE VUELO INSTRUMENTAL Nº7', 'codigos' => 'G-7'],
            ['unidad' => 'GRUPO AÉREO DE INTELIGENCIA, VIGILANCIA Y RECONOCIMIENTO ELECTRÓNICO Nº8', 'codigos' => 'G-8'],
            ['unidad' => 'GRUPO AÉREO DE TRANSPORTE Nº9', 'codigos' => 'G-9'],
            ['unidad' => 'GRUPO AÉREO DE OPERACIONES ESPECIALES Nº15', 'codigos' => 'G-10'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº11', 'codigos' => 'G-11'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº12', 'codigos' => 'G-12'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº13', 'codigos' => 'G-13'],
            ['unidad' => 'GRUPO DE ENTRENAMIENTO AÉREO Nº14', 'codigos' => 'G-14'],
            ['unidad' => 'GRUPO AÉREO DE OPERACIONES ESPECIALES Nº15', 'codigos' => 'G-15'],
            ['unidad' => 'GRUPO AÉREO DE CAZA Nº16', 'codigos' => 'G-16'],
            ['unidad' => 'GRUPO AÉREO DE OPERACIONES ESPECIALES Nº17', 'codigos' => 'G-17'],
            ['unidad' => 'GRUPO DE ENTRENAMIENTO AÉREO Nº18', 'codigos' => 'G-18'],
            ['unidad' => 'GRUPO DE ENTRENAMIENTO AÉREO Nº19', 'codigos' => 'G-19'],
        ];
    
        foreach ($items as $item) {
            AeronaveUnidades::create($item);
        }

        
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        
    }
}
