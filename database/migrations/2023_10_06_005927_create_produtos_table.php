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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo_de_barras');
            $table->string('unidade_de_medida');
            $table->decimal('quantidade_em_estoque', 10, 2)->nullable();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->date('data_atualizacao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
