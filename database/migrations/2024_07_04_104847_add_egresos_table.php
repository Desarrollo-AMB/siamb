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
        Schema::table('egresos', function (Blueprint $table) {
            $table->date('fecha_fallecido')->nullable();
            $table->string('resuelto_fallecido',255)->nullable();
            $table->string('deseso',255)->nullable();
            $table->date('fecha_reuelto_dfs')->nullable();

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
