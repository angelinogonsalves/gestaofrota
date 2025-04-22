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
        Schema::create('movimentacao_de_produtos', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_de_movimentacao')->comment('1: Entrada, 2: Saída');
            $table->decimal('quantidade', 10, 2)->nullable();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->date('data_atualizacao')->nullable();
            $table->timestamps();
            $table->foreignId('produto_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('responsavel_retirada');
            $table->string('responsavel_recebimento');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacao_de_produtos');
    }
};
