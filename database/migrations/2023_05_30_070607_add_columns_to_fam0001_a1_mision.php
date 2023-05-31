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
            $table->string('cod1')->nullable();
            $table->string('hv1')->nullable();
            $table->string('cod2')->nullable();
            $table->string('hv2')->nullable();
            $table->string('cod3')->nullable();
            $table->string('hv3')->nullable();
            $table->string('cod4')->nullable();
            $table->string('hv4')->nullable();
            $table->string('cod5')->nullable();
            $table->string('hv5')->nullable();
            $table->string('cod6')->nullable();
            $table->string('hv6')->nullable();
            $table->string('cod7')->nullable();
            $table->string('hv7')->nullable();
            $table->string('cod8')->nullable();
            $table->string('hv8')->nullable();
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
            $table->dropColumn(['cod1', 'hv1', 'cod2', 'hv2', 'cod3', 'hv3', 'cod4', 'hv4', 'cod5', 'hv5', 'cod6', 'hv6', 'cod7', 'hv7', 'cod8', 'hv8']);
        });
    }
};
