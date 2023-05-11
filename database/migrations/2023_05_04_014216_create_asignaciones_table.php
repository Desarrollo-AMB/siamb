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
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_empleado')->nullable();
            $table->integer('id_concepto')->nullable();
            $table->string('tipo_concepto',255)->nullable();
            $table->timestamps();//created_at updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaciones');
        Schema::table('asignaciones',function(Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
};