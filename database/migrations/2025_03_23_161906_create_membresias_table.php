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
        Schema::create('membresias', function (Blueprint $table) {
            $table->id('id_membresia');
            $table->unsignedBigInteger('id_socio');
            $table->foreign('id_socio')->references('id_socio')->on('socios')->onDelete('cascade');
            $table->unsignedBigInteger('id_plan');
            $table->foreign('id_plan')->references('id_plan')->on('planes');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->check('fecha_fin > fecha_inicio');
            $table->decimal('costo', 10, 2)->check('costo > 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};
