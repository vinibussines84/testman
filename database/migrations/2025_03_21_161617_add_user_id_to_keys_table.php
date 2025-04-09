<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Permite NULL
        });
    }
    
    public function down()
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
        };
