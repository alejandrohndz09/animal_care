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
        Schema::table('raza', function (Blueprint $table) {
            $table->foreign(['idEspecie'], 'fk_esp-raz')->references(['idEspecie'])->on('especie')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raza', function (Blueprint $table) {
            $table->dropForeign('fk_esp-raz');
        });
    }
};
