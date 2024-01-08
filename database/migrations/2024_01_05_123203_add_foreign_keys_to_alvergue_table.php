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
        Schema::table('alvergue', function (Blueprint $table) {
            $table->foreign(['idMiembro'], 'fk_alv-mbr')->references(['idMiembro'])->on('miembro')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alvergue', function (Blueprint $table) {
            $table->dropForeign('fk_alv-mbr');
        });
    }
};
