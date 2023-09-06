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
        Schema::table('unidadmedida', function (Blueprint $table) {
            $table->foreign(['idCategoria'], 'unidadmedida_ibfk_1')->references(['idCategoria'])->on('categoria')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidadmedida', function (Blueprint $table) {
            $table->dropForeign('unidadmedida_ibfk_1');
        });
    }
};
