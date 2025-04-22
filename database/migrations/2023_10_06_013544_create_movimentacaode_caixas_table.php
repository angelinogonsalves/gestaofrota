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
        Schema::create('movimentacao_de_caixas', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_de_movimentacao')->comment('1: Entrada, 2: Saída');
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('motivo')->nullable();
            $table->date('data_movimentacao');
            $table->timestamps();
            $table->foreignId('caixa_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('frete_id')->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacao_de_caixas');
    }
};
