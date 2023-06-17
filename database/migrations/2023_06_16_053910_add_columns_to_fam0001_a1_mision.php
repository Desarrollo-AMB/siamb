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
        Schema::table('fam0001_a1_mision', function (Blueprint $table) {
            $table->string('fecha')->nullable();
            $table->string('motivo_cancel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fam0001_a1_mision', function (Blueprint $table) {
            $table->dropColumn(['fecha', 'motivo_cancel']);
        });
    }
};
