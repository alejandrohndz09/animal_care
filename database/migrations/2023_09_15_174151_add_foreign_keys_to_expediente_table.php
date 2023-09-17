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
        Schema::table('expediente', function (Blueprint $table) {
            $table->foreign(['idAnimal'], 'fk_aml-exp')->references(['idAnimal'])->on('animal')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['idAlvergue'], 'expediente_ibfk_1')->references(['idAlvergue'])->on('alvergue')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expediente', function (Blueprint $table) {
            $table->dropForeign('fk_aml-exp');
            $table->dropForeign('expediente_ibfk_1');
        });
    }
};
