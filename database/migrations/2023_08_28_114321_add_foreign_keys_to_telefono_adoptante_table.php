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
        Schema::table('telefono_adoptante', function (Blueprint $table) {
            $table->foreign(['idAdoptante'], 'telefono_adoptante')->references(['idAdoptante'])->on('adoptante')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telefono_adoptante', function (Blueprint $table) {
            $table->dropForeign('telefono_adoptante');
        });
    }
};
