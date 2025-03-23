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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nom', 50);
            $table->string('ap', 50);
            $table->string('am', 50);
            $table->string('telefono', 15);
            $table->string('correo', 30)->unique();
            $table->string('contrasena', 60);
            $table->unsignedBigInteger('id_rol'); // Usamos unsignedBigInteger para que coincida con el tipo de id_rol en roles
            $table->foreign('id_rol')->references('id_rol')->on('roles')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
