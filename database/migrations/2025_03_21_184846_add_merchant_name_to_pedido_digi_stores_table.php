<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMerchantNameToPedidoDigiStoresTable extends Migration
{
    public function up()
    {
        Schema::table('pedido_digi_stores', function (Blueprint $table) {
            $table->string('merchant_name')->nullable(); // Adiciona a coluna merchant_name
        });
    }

    public function down()
    {
        Schema::table('pedido_digi_stores', function (Blueprint $table) {
            $table->dropColumn('merchant_name'); // Remove a coluna merchant_name, se necessário
        });
    }
}
