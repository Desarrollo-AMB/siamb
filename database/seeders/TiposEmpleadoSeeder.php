<?php

namespace Database\Seeders;

use App\Models\TiposEmpleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['tipo_emp' => 'CON', 'descripcion' => 'CONTRATADOS', 'clasificacion'=>'C', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'V','requiere_puesto'=>'N'],
            ['tipo_emp' => 'EMP', 'descripcion' => 'EMPLEADOS', 'clasificacion'=>'E', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'J','requiere_puesto'=>'N'],
            ['tipo_emp' => 'OBR', 'descripcion' => 'OBREROS', 'clasificacion'=>'O', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'J','requiere_puesto'=>'N'],
            ['tipo_emp' => 'DOC', 'descripcion' => 'DOCENTE FIJO', 'clasificacion'=>'D', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'J','requiere_puesto'=>'N'],
            ['tipo_emp' => 'MIL', 'descripcion' => 'MILITAR PROFESIONAL', 'clasificacion'=>'M', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'M','requiere_puesto'=>'N'],
            ['tipo_emp' => 'MEX', 'descripcion' => 'MILITAR EN EL EXTERIOR', 'clasificacion'=>'M', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'X','requiere_puesto'=>'N'],
            ['tipo_emp' => 'TRP', 'descripcion' => 'TROPA PROFESIONAL', 'clasificacion'=>'M', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'M','requiere_puesto'=>'N'],
            ['tipo_emp' => 'ALI', 'descripcion' => 'ALISTADO', 'clasificacion'=>'M', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'F','requiere_puesto'=>'N'],
            ['tipo_emp' => 'MED', 'descripcion' => 'MEDICOS', 'clasificacion'=>'I', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'V','requiere_puesto'=>'N'],
            ['tipo_emp' => 'MEF', 'descripcion' => 'MILITAR EN FORMACION', 'clasificacion'=>'M', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'F','requiere_puesto'=>'N'],
            ['tipo_emp' => 'CEX', 'descripcion' => 'CIVIL EXTERIOR', 'clasificacion'=>'E', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'A','requiere_puesto'=>'N'],
            ['tipo_emp' => 'DTC', 'descripcion' => 'DOCENTES CONVENCIONAL', 'clasificacion'=>'E', 'codigo_contable'=>'', 'codigo_cia'=>'01','codigo_presupuestario'='','aplicacion_nomina'=>'V','requiere_puesto'=>'N'],
        ];
    
        foreach ($items as $item) {
            TiposEmpleado::create($item);
        }
        
    }
}
