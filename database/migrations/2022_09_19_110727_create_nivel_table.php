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
        Schema::create('nivel', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',2)->unique()->nullable();
            $table->string('descripcion',35)->nullable();
            $table->string('nivel_instruccion',2)->nullable();
            $table->integer('is_deleted')->default(0);
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
        Schema::dropIfExists('nivel');
    }
};
