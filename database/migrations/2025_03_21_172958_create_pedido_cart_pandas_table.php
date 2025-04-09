<?php

// database/migrations/xxxx_xx_xx_create_pedido_cart_pandas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoCartPandasTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_cart_pandas', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();  // Número do pedido, único
            $table->decimal('total_amount', 8, 2);     // Valor total do pedido
            $table->string('status');                  // Status do pedido
            $table->timestamps();                      // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_cart_pandas');
    }
}
