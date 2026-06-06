<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // Ex: FT AGT2026/001
            $table->string('customer_nif');             // NIF do Cliente em Angola
            $table->string('customer_name');            // Nome do Cliente / Empresa
            $table->decimal('total_amount', 12, 2);     // Valor total da fatura
            $table->string('pdf_path')->nullable();     // Caminho do ficheiro PDF guardado
            $table->date('emission_date');              // Data em que foi emitida na AGT
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
        Schema::dropIfExists('invoices');
    }
}
