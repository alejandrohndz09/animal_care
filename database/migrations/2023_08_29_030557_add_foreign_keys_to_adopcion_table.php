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
        Schema::table('adopcion', function (Blueprint $table) {
            $table->foreign(['idExpediente'], 'adopcion_ibfk_2')->references(['idExpediente'])->on('expediente')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['idAdoptante'], 'adopcion_ibfk_1')->references(['idAdoptante'])->on('adoptante')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['idMiembro'], 'adopcion_ibfk_3')->references(['idMiembro'])->on('miembro')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adopcion', function (Blueprint $table) {
            $table->dropForeign('adopcion_ibfk_2');
            $table->dropForeign('adopcion_ibfk_1');
            $table->dropForeign('adopcion_ibfk_3');
        });
    }
};
