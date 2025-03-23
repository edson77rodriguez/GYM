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
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->id('id_detalle_venta');
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_venta')->references('id_venta')->on('ventas')->onDelete('cascade');
            $table->unsignedBigInteger('id_suplemento');
            $table->foreign('id_suplemento')->references('id_suplemento')->on('suplementos');
            $table->integer('cantidad')->check('cantidad > 0');
            $table->decimal('subtotal', 10, 2)->check('subtotal > 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_ventas');
    }
};
