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
        Schema::create('hogar', function (Blueprint $table) {
            $table->string('idHogar', 7)->primary();
            $table->string('direccion')->nullable();
            $table->integer('companiaHumana')->nullable();
            $table->integer('companiaAnimal')->nullable();
            $table->string('tamanioHogar', 30)->nullable();
            $table->integer('estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hogar');
    }
};
