<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderDateToPedidoDigiStoresTable extends Migration
{
    public function up()
    {
        Schema::table('pedido_digi_stores', function (Blueprint $table) {
            $table->dateTime('order_date')->nullable(); // Adiciona a coluna order_date
        });
    }

    public function down()
    {
        Schema::table('pedido_digi_stores', function (Blueprint $table) {
            $table->dropColumn('order_date'); // Remove a coluna order_date, se necessário
        });
    }
}
