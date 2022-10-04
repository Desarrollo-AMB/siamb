<?php

namespace Database\Seeders;

use App\Models\CategoriasMilitares;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasMilitaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['codigo_categoria' => '02', 'descripcion' => 'ASIMILADO', 'tipo_emp'=>'MIL'],
            ['codigo_categoria' => '03', 'descripcion' => 'RESERVA', 'tipo_emp'=>''],
            ['codigo_categoria' => '05', 'descripcion' => 'EFECTIVO TECNICO', 'tipo_emp'=>'MIL'],
            ['codigo_categoria' => '04', 'descripcion' => 'EFECTIVO COMANDO', 'tipo_emp'=>'MIL'],
            ['codigo_categoria' => '00', 'descripcion' => 'PM NO PROFESIONAL', 'tipo_emp'=>'MEF'],
            ['codigo_categoria' => '06', 'descripcion' => 'ASIMILADO TECNICO', 'tipo_emp'=>'MIL'],
            ['codigo_categoria' => '07', 'descripcion' => 'EFECTIVO CMDO TROPA', 'tipo_emp'=>'MIL'],
            ['codigo_categoria' => '08', 'descripcion' => 'TROPA PROFESIONAL', 'tipo_emp'=>'TRP'],
        ];
    
        foreach ($items as $item) {
            CategoriasMilitares::create($item);
        }
        
    }
}
