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
        Schema::create('movimiento', function (Blueprint $table) {
            $table->string('idMovimiento', 7)->primary();
            $table->text('descripcion')->nullable();
            $table->dateTime('fechaMovimento')->nullable();
            $table->string('tipoMovimiento', 25)->nullable();
            $table->double('valor')->nullable();
            $table->string('idMiembro', 7)->nullable()->index('idMiembro');
            $table->string('idRecurso', 7)->nullable()->index('idRecurso');
            $table->string('idDonante', 7)->nullable()->index('idDonante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimiento');
    }
};
