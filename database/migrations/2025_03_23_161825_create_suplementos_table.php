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
        Schema::create('suplementos', function (Blueprint $table) {
            $table->id('id_suplemento');
            $table->string('nom_suplemento', 50)->unique();
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias');
            $table->unsignedBigInteger('id_marca');
            $table->foreign('id_marca')->references('id_marca')->on('marcas');
            $table->text('desc_suplemento');
            $table->decimal('precio', 10, 2)->check('precio > 0');
            $table->integer('stock')->check('stock >= 0');
            $table->string('imagen_suplemento')->nullable(); // Agregar campo para imagen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suplementos');
    }
};
