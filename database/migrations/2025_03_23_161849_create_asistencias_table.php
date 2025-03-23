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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('id_asistencia');
            $table->unsignedBigInteger('id_socio');
            $table->foreign('id_socio')->references('id_socio')->on('socios')->onDelete('cascade');
            $table->date('fecha_asi')->default(DB::raw('CURRENT_DATE'));
            $table->time('hora_entrada');
            $table->time('hora_salida')->nullable()->check('hora_salida > hora_entrada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
