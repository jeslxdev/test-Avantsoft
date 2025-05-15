<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('razao_social')->nullable(); // Para clientes do tipo 'juridica'
            $table->string('nome_fantasia')->nullable(); // Para clientes do tipo 'juridica'
            $table->string('email')->unique();
            $table->string('cpfCnpj')->unique();
            $table->string('telefone');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado');
            $table->string('cep');
            $table->string('pais');
            $table->string('tipo_cliente'); // 'fisica' ou 'juridica'
            $table->date('data_nascimento');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
