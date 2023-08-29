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
        Schema::create('historialpatologia', function (Blueprint $table) {
            $table->string('idHistPatologia', 7)->primary();
            $table->date('fechaDiagnostico')->nullable();
            $table->string('idPatologia', 7)->nullable()->index('fk_pat-htp');
            $table->text('datalles')->nullable();
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('historialpatologia');
    }
};
