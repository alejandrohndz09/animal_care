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
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('idUsuario', 7)->primary();
            $table->text('usuario')->nullable();
            $table->text('clave')->nullable();
            $table->text('token')->nullable();
            $table->string('idMiembro', 7)->nullable()->index('idMiembro');
            $table->integer('rol')->default(2)->comment('1=admin, 2=usuario');
            $table->integer('estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};
