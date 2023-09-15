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
        Schema::create('adopcion', function (Blueprint $table) {
            $table->string('idAdopcion', 7)->primary();
            $table->date('fechaTramiteInicio')->nullable();
            $table->date('fechaTramiteFin')->nullable();
            $table->string('idAdoptante', 7)->nullable()->index('idAdoptante');
            $table->string('idExpediente', 7)->nullable()->index('idExpediente');
            $table->string('idMiembro', 7)->nullable()->index('idMiembro');
            $table->integer('aceptacion')->nullable();
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
        Schema::dropIfExists('adopcion');
    }
};
