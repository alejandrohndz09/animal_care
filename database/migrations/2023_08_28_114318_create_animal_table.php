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
        Schema::create('animal', function (Blueprint $table) {
            $table->string('idAnimal', 7)->primary();
            $table->string('nombre')->nullable();
            $table->date('fechaNacimiento')->nullable();
            $table->string('sexo', 12)->nullable();
            $table->text('particularidad')->nullable();
            $table->integer('idRaza')->nullable()->index('fk_raz-ani');
            $table->text('imagen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal');
    }
};
