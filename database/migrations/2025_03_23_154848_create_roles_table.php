<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->integer('id_rol', true);
            $table->string('nom_rol')->unique();
            $table->string('desc_rol');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
