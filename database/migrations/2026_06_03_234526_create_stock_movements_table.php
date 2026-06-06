<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            // Liga a movimentação ao ID do produto. Se o produto for apagado, apaga o histórico dele.
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['entrada', 'saida']); // Apenas aceita estes dois tipos
            $table->integer('quantity');                // Quantidade movimentada
            $table->string('reason')->nullable();       // Motivo (Ex: Venda, Compra)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}
