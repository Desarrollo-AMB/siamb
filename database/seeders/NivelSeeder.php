<?php

namespace Database\Seeders;

use App\Models\Nivel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['codigo' => 'K', 'descripcion' => 'DESCONOCIDO', 'nivel_instruccion'=>'0'],
            ['codigo' => 'A', 'descripcion' => 'INICIAL (PREESCOLAR)', 'nivel_instruccion'=>'1'],
            ['codigo' => 'B', 'descripcion' => 'BASICA (1º A 6º GRADO)', 'nivel_instruccion'=>'2'],
            ['codigo' => 'C', 'descripcion' => 'MEDIA (7º A 9º GRADO)', 'nivel_instruccion'=>'2'],
            ['codigo' => 'D', 'descripcion' => 'DIVERSIFICADA (4º Y 5º AÑO)', 'nivel_instruccion'=>'3'],
            ['codigo' => 'E', 'descripcion' => 'TÈCNICO MEDIO (4º,5º y/o 6º AÑO)', 'nivel_instruccion'=>'4'],
            ['codigo' => 'F', 'descripcion' => 'TÈCNICO SUPERIOR UNIVERSITARIO', 'nivel_instruccion'=>'5'],
            ['codigo' => 'G', 'descripcion' => 'PREGRADO', 'nivel_instruccion'=>'6'],
            ['codigo' => 'H', 'descripcion' => 'ESPECIALIZACION', 'nivel_instruccion'=>'6'],
            ['codigo' => 'I', 'descripcion' => 'MAESTRIA', 'nivel_instruccion'=>'7'],
            ['codigo' => 'J', 'descripcion' => 'DOCTORADO', 'nivel_instruccion'=>'8'],
        ];
    
        foreach ($items as $item) {
            Nivel::create($item);
        }
        
    }
}
