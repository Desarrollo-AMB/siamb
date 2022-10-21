<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            AeronaveUnidadesSeeder::class,
            NivelSeeder::class,
            BasesSeeder::class,
            TiposEmpleadoSeeder::class,
            CategoriasMilitaresSeeder::class,
        ]);
        $this->command->info('Seeder ejecutados!');

        //Para insertar datos por medio de archivos SQL
        $this->command->info('Iniciando Insercion de Datos por SQL!');

        $path = 'database/sql/ubicaciones.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "ubicaciones" ejecutado!');

        $path = 'database/sql/cargos.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "cargos" ejecutado!');

        $path = 'database/sql/paises.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "paises" ejecutado!');

        $path = 'database/sql/estados.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "estados" ejecutado!');

        $path = 'database/sql/ciudades.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "ciudades" ejecutado!');

        $path = 'database/sql/grados_militares.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "grados_militares" ejecutado!');

        $path = 'database/sql/ubicaciones_detalladas.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "ubicaciones_detalladas" ejecutado!');

        $path = 'database/sql/universidades.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "universidades" ejecutado!');

       /* $this->command->info('Tabla "empleados", por favor espere...');
        $path = 'database/sql/empleados.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "empleados" ejecutado!');

        $this->command->info('Tabla "nomina", por favor espere...');
        $path = 'database/sql/nomina.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "nomina" ejecutado!');*/

        $path = 'database/sql/articulo_hijo.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "articulo_hijo" (SEID) ejecutado!');

        $path = 'database/sql/aparte_nieto.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "aparte_nieto" (SEID) ejecutado!');

        $path = 'database/sql/especialidades_militares.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "especialidades_militares" (SEID) ejecutado!');

        $path = 'database/sql/notempleados.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "empleados_otro_componente" (SEID) ejecutado!');


        $path = 'database/sql/profesiones.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('SQL Insert tabla "profesiones" ejecutado!');
    }
}
