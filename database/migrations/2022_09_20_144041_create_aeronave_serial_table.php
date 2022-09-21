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
        Schema::create('aeronave_serial', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->foreignId('aeronave_id')->constrained('aeronave_modelo');
            //$table->foreign('aeronave_id')->references('id')->on('aeronave_modelo');
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
        Schema::dropIfExists('aeronave_serial');
    }
};
