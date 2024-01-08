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
        Schema::create('donante', function (Blueprint $table) {
            $table->string('idDonante', 7)->nullable()->index('idDonante');
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('dui', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donante');
    }
};
