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
        Schema::create('expediente', function (Blueprint $table) {
            $table->string('idExpediente', 7)->primary();
            $table->string('idAnimal', 7)->nullable()->index('fk_aml-exp');
            $table->string('idAlvergue', 7)->nullable()->index('expediente_ibfk_1');
            $table->date('fechaIngreso')->nullable();
            $table->string('estadoGeneral', 40)->nullable()->comment('Controlado, albergado, en proceso de adopción, adoptado');
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
        Schema::dropIfExists('expediente');
    }
};
