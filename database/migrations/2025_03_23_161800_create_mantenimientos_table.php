<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id('id_mantenimiento');
            $table->unsignedBigInteger('id_equipo');
            $table->foreign('id_equipo')->references('id_equipo')->on('equipos')->onDelete('cascade');
            $table->unsignedBigInteger('id_empleado');
            $table->foreign('id_empleado')->references('id_empleado')->on('empleados');
            $table->date('fecha_programada');
            $table->text('desc_estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
