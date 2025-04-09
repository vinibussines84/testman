<?php

// database/migrations/xxxx_xx_xx_create_pedido_digi_stores_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoDigiStoresTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_digi_stores', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Número do pedido, único
            $table->decimal('total_amount', 8, 2);    // Valor total do pedido
            $table->string('status');                 // Status do pedido
            $table->string('billing_first_name');     // Nome do comprador
            $table->string('product_name');           // Nome do produto
            $table->integer('quantity');              // Quantidade do produto
            $table->decimal('transaction_amount', 8, 2); // Valor da transação
            $table->timestamps();                     // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_digi_stores');
    }
}
