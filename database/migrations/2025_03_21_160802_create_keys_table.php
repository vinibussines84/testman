<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeysTable extends Migration
{
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->id();
            $table->string('shop_slug')->unique();
            $table->string('authorization');
            $table->string('token');
            $table->string('x_api_key');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keys');
    }
}
