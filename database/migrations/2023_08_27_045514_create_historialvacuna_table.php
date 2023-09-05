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
        Schema::create('historialvacuna', function (Blueprint $table) {
            $table->string('idHistVacuna', 7)->primary();
            $table->string('fechaAplicacion')->nullable();
            $table->integer('dosis')->nullable();
            $table->string('idVacuna', 7)->nullable()->index('fk_vac-htv');
            $table->string('idExpediente', 7)->nullable()->index('idExpediente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historialvacuna');
    }
};
