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
        Schema::table('historialvacuna', function (Blueprint $table) {
            $table->foreign(['idExpediente'], 'historialvacuna_ibfk_1')->references(['idExpediente'])->on('expediente')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['idVacuna'], 'fk_vac-htv')->references(['idVacuna'])->on('vacuna')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historialvacuna', function (Blueprint $table) {
            $table->dropForeign('historialvacuna_ibfk_1');
            $table->dropForeign('fk_vac-htv');
        });
    }
};
