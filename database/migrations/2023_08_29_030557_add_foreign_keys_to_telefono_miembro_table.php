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
        Schema::table('telefono_miembro', function (Blueprint $table) {
            $table->foreign(['idMiembro'], 'fk_tlf-mbr')->references(['idMiembro'])->on('miembro')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telefono_miembro', function (Blueprint $table) {
            $table->dropForeign('fk_tlf-mbr');
        });
    }
};
