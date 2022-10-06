<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_militares', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->integer('codigo_categoria')->nullable();
            $table->string('codigo_promocion',4)->nullable();
            $table->integer('orden_merito')->nullable();
            $table->integer('total_orden_merito')->nullable();
            $table->string('cursos')->nullable();
            $table->string('codigo_pais',4)->nullable();
            $table->date('fecha_ultimo_ascenso')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->string('codigo_especialidad1',6)->nullable();
            $table->string('codigo_especialidad2',6)->nullable();
            $table->date('fecha_graduacion')->nullable();
            $table->string('codigo_condicion',2)->nullable();
            $table->integer('ano_cursados')->nullable();
            $table->string('contingente',4)->nullable();
            $table->string('observaciones',255)->nullable();
            $table->date('fecha_tentativa')->nullable();
            $table->string('codigo_discracate',2)->nullable();
            $table->string('user_created',100)->nullable();
            $table->string('user_updated',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_militares');
    }
};
