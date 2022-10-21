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
        Schema::create('profesiones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_profesion',4)->nullable();
            $table->string('descripcion',150)->nullable();
            $table->string('codigo_carrera',2)->nullable();
            $table->integer('is_deleted')->default(0);
            $table->string('user_created',100)->nullable();
            $table->string('user_updated',100)->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('profesiones');
    }
};
