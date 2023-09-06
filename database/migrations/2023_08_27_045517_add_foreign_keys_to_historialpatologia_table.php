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
        Schema::table('historialpatologia', function (Blueprint $table) {
            $table->foreign(['idPatologia'], 'fk_pat-htp')->references(['idPatologia'])->on('patologia')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['idExpediente'], 'historialpatologia_ibfk_1')->references(['idExpediente'])->on('expediente')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historialpatologia', function (Blueprint $table) {
            $table->dropForeign('fk_pat-htp');
            $table->dropForeign('historialpatologia_ibfk_1');
        });
    }
};
