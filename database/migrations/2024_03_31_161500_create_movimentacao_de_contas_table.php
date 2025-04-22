<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimentacao_de_contas', function (Blueprint $table) {
            $table->id();
            $table->date('pagamento')->nullable();
            $table->integer('tipo_de_movimentacao')->comment('1: Entrada, 2: Saída');
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('motivo')->nullable();
            $table->string('tipo_pagamento')->nullable()->comment('Boleto, Pix');
            $table->timestamps();
            $table->foreignId('conta_id')->references('id')->on('contas');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('cliente_id')->references('id')->on('clientes');
            $table->foreignId('fornecedor_id')->references('id')->on('fornecedores');
            $table->text('caminho_arquivo_pdf')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacao_de_contas');
    }
};
