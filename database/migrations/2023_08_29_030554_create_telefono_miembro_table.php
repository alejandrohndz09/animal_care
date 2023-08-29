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
        Schema::create('telefono_miembro', function (Blueprint $table) {
            $table->integer('idTelefono', true);
            $table->string('telefono', 15)->nullable();
            $table->string('idMiembro', 7)->nullable()->index('fk_tlf-mbr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telefono_miembro');
    }
};
