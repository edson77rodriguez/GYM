<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->string('nom_equipo', 50)->unique();
            $table->text('desc_equipo');
            $table->string('imagen_equipo')->nullable(); // Imagen
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipos');
    }
};

