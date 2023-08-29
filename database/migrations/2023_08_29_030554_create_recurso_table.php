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
        Schema::create('recurso', function (Blueprint $table) {
            $table->string('idRecurso', 7)->primary();
            $table->text('recurso')->nullable();
            $table->string('idCategoria', 7)->nullable()->index('idCategoria');
            $table->double('cantidad')->nullable();
            $table->string('idUnidadMedida', 7)->nullable()->index('idUnidadMedida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recurso');
    }
};
