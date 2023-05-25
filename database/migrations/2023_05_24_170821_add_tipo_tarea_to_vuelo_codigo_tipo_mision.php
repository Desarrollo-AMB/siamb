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
        Schema::table('vuelo_codigo_tipo_mision', function (Blueprint $table) {
            $table->string('tipo_tarea')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vuelo_codigo_tipo_mision', function (Blueprint $table) {
            $table->dropColumn('tipo_tarea');
        });
    }
};
