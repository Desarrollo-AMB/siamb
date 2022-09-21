<?php

namespace Database\Seeders;

use App\Models\Base;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['codigo_zona' => '1', 'codigo_base'=>'K', 'siglas'=>'VIGIA', 'descripcion' => 'BASE AÉREA TACTICA BATA EL VIGIA'],
            ['codigo_zona' => '1', 'codigo_base'=>'M', 'siglas'=>'BAVIVAS', 'descripcion' => 'BASE AÉREA TTE BUENAVENTURA VIVAS'],
            ['codigo_zona' => '2', 'codigo_base'=>'D', 'siglas'=>'BALANDA', 'descripcion' => 'BASE AÉREA TTE. VICENTE LANDAETA GIL'],
            ['codigo_zona' => '3', 'codigo_base'=>'B', 'siglas'=>'BAEL', 'descripcion' => 'BASE AÉREA LIBERTADOR'],
            ['codigo_zona' => '3', 'codigo_base'=>'E', 'siglas'=>'BAMARI', 'descripcion' => 'BASE AÉREA CAPITAN MANUEL RIOS'],
            ['codigo_zona' => '3', 'codigo_base'=>'H', 'siglas'=>'BARAGUA', 'descripcion' => 'BASE LOGÍSTICA BARAGUA'],
            ['codigo_zona' => '3', 'codigo_base'=>'J', 'siglas'=>'BASUCRE', 'descripcion' => 'BASE AÉREA MARISCAL ANTONIO JOSÉ DE SUCRE'],
            ['codigo_zona' => '4', 'codigo_base'=>'A', 'siglas'=>'BACACERES', 'descripcion' => 'BASE AÉREA TACTICA LUISA CACEREAS DE ARISMENDI'],
            ['codigo_zona' => '4', 'codigo_base'=>'F', 'siglas'=>'BAMENDEZ', 'descripcion' => 'BASE AÉREA TACTICA BATA MENDEZ'],
            ['codigo_zona' => '4', 'codigo_base'=>'L', 'siglas'=>'BAVALLE', 'descripcion' => 'BASE AÉREA TTE. LUIS DEL VALLE GARCÍA'],
            ['codigo_zona' => '5', 'codigo_base'=>'C', 'siglas'=>'BAGFM', 'descripcion' => 'BASE AÉREA GENERALÍSIMO FRANCISCO DE MIRANDA'],
            ['codigo_zona' => '5', 'codigo_base'=>'G', 'siglas'=>'BAPAEZ', 'descripcion' => 'BASE AÉREA GRAL. JOSÉ ANTONIO PAEZ'],
            ['codigo_zona' => '5', 'codigo_base'=>'O', 'siglas'=>'COA', 'descripcion' => 'CMDO. DEL COA BASE AÉREA BAGFM'],
            ['codigo_zona' => '0', 'codigo_base'=>'N', 'siglas'=>'SB', 'descripcion' => 'SIN BASE'],
            ['codigo_zona' => '5', 'codigo_base'=>'P', 'siglas'=>'ESMERALDA', 'descripcion' => 'BASE AÈREA LA ESMERALDA'],
            ['codigo_zona' => '4', 'codigo_base'=>'Q', 'siglas'=>'ORINOCO', 'descripcion' => 'BASE AÉREA TÁCTICA AVANZADA ORINOCO'],
            ['codigo_zona' => '1', 'codigo_base'=>'I', 'siglas'=>'BARU', 'descripcion' => 'BASE AÉREA GRAL. RAFAEL URDANETA'],
        ];
    
        foreach ($items as $item) {
            Base::create($item);
        }
        
    }
}
