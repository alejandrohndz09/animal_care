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
        Schema::table('recurso', function (Blueprint $table) {
            $table->foreign(['idCategoria'], 'recurso_ibfk_1')->references(['idCategoria'])->on('categoria')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['idUnidadMedida'], 'recurso_ibfk_2')->references(['idUnidadMedida'])->on('unidadmedida')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recurso', function (Blueprint $table) {
            $table->dropForeign('recurso_ibfk_1');
            $table->dropForeign('recurso_ibfk_2');
        });
    }
};
