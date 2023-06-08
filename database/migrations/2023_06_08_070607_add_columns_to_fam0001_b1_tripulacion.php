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
        Schema::table('fam0001_b1_tripulacion', function (Blueprint $table) {
            $table->string('func1')->nullable();
            $table->string('cod1')->nullable();
            $table->string('hv1')->nullable();
            $table->string('func2')->nullable();
            $table->string('cod2')->nullable();
            $table->string('hv2')->nullable();
            $table->string('func3')->nullable();
            $table->string('cod3')->nullable();
            $table->string('hv3')->nullable();
            $table->string('func4')->nullable();
            $table->string('cod4')->nullable();
            $table->string('hv4')->nullable();
            $table->string('func5')->nullable();
            $table->string('cod5')->nullable();
            $table->string('hv5')->nullable();
            $table->string('func6')->nullable();
            $table->string('cod6')->nullable();
            $table->string('hv6')->nullable();
            $table->string('func7')->nullable();
            $table->string('cod7')->nullable();
            $table->string('hv7')->nullable();
            $table->string('func8')->nullable();
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
        Schema::table('fam0001_b1_tripulacion', function (Blueprint $table) {
            $table->dropColumn(['func1', 'cod1', 'hv1', 'func2', 'cod2', 'hv2', 'func3', 'cod3', 'hv3', 'func4', 'cod4', 'hv4', 'func5', 'cod5', 'hv5', 'func6', 'cod6', 'hv6', 'func7', 'cod7', 'hv7', 'func8', 'cod8', 'hv8']);
        });
    }
};
