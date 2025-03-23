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
        Schema::create('socios', function (Blueprint $table) {
            $table->id('id_socio');
            $table->unsignedBigInteger('id_persona');
            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->date('fecha_inscripcion');
            $table->date('fecha_vencimiento')->check('fecha_vencimiento > fecha_inscripcion');
            $table->unsignedBigInteger('id_estado_mem');
            $table->foreign('id_estado_mem')->references('id_estado_mem')->on('estados_membresias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
