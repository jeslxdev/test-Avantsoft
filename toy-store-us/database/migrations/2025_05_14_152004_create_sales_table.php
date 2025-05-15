<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade'); // Relaciona com a tabela clientes
            $table->date('data_venda');
            $table->decimal('valor', 10, 2);
            $table->boolean('parcelada')->default(false); // Se a venda foi parcelada ou não
            $table->string('metodo_pagamento'); // Cartão de crédito, boleto, etc.
            $table->enum('status_venda', [
                'em analise', 'enviado', 'em rota', 'devolvida', 'concluida'
            ]);
            $table->enum('status_pagamento', [
                'pagamento confirmado', 'pagamento recusado', 'pagamento em processamento', 
                'devolução', 'estornado'
            ]);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}

