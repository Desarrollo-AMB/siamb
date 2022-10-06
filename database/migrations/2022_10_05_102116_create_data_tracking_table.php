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
        Schema::create('data_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('action', 20);
            $table->string('table', 50);
            $table->bigInteger('data_id')->nullable();
            $table->json('old_value')->nullable();
            $table->json('new_value');
            $table->datetime('modified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_tracking');
    }
};
