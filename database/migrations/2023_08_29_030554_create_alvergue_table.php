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
        Schema::create('alvergue', function (Blueprint $table) {
            $table->string('idAlvergue', 6)->primary();
            $table->string('direccion')->nullable();
            $table->string('idMiembro', 7)->nullable()->index('fk_alv-mbr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alvergue');
    }
};
