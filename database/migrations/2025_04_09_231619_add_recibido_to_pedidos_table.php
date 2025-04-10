<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // En la migración generada
public function up()
{
    Schema::table('pedidos', function (Blueprint $table) {
        $table->boolean('recibido')->default(false)->after('fecha_pedido');
    });
}

public function down()
{
    Schema::table('pedidos', function (Blueprint $table) {
        $table->dropColumn('recibido');
    });
}
};
