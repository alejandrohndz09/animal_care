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
            $table->foreign(['idEspecie'], 'raza_ibfk_1')->references(['idEspecie'])->on('especie')->onUpdate('CASCADE')->onDelete('NO ACTION');
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
            $table->dropForeign('raza_ibfk_1');
        });
    }
};
