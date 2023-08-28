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
        Schema::create('adoptante', function (Blueprint $table) {
            $table->string('idAdoptante', 7)->primary();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('dui', 10)->nullable();
            $table->string('idHogar', 7)->nullable()->index('fk_hgr-adp');
            $table->integer('estado')->nullable()->comment('0 = inactivo, 1 = activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adoptante');
    }
};
