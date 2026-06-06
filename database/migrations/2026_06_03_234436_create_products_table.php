<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique(); // Código único (Ex: PROD-001)
            $table->string('name');          // Nome do produto
            $table->string('category');      // Categoria (Ex: Periféricos)
            $table->decimal('price', 10, 2); // Preço com 2 casas decimais
            $table->integer('stock')->default(0); // Quantidade atual em stock
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
        Schema::dropIfExists('products');
    }
}
