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
        Schema::table('adoptante', function (Blueprint $table) {
            $table->foreign(['idHogar'], 'fk_hgr-adp')->references(['idHogar'])->on('hogar')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adoptante', function (Blueprint $table) {
            $table->dropForeign('fk_hgr-adp');
        });
    }
};
