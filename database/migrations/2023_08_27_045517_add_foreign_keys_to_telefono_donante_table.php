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
        Schema::table('telefono_donante', function (Blueprint $table) {
            $table->foreign(['idDonante'], 'telefono_donante_ibfk_1')->references(['idDonante'])->on('donante')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telefono_donante', function (Blueprint $table) {
            $table->dropForeign('telefono_donante_ibfk_1');
        });
    }
};
