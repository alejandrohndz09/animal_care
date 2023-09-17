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
        Schema::table('movimiento', function (Blueprint $table) {
            $table->foreign(['idRecurso'], 'movimiento_ibfk_2')->references(['idRecurso'])->on('recurso')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['idMiembro'], 'movimiento_ibfk_1')->references(['idMiembro'])->on('miembro')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['idDonante'], 'movimiento_ibfk_3')->references(['idDonante'])->on('donante')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimiento', function (Blueprint $table) {
            $table->dropForeign('movimiento_ibfk_2');
            $table->dropForeign('movimiento_ibfk_1');
            $table->dropForeign('movimiento_ibfk_3');
        });
    }
};
