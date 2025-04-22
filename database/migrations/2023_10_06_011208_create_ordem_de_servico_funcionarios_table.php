<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordem_de_servico_funcionarios', function (Blueprint $table) {
            $table->id();
            $table->decimal('tempo', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->timestamps();
            $table->foreignId('funcionario_id')->constrained();
            $table->foreignId('ordem_de_servico_id')->constrained();
            $table->softDeletes();
        });

        // Definindo o próximo ID para 100 após a criação da tabela
        DB::statement("ALTER TABLE ordem_de_servico_funcionarios AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordem_de_servico_funcionarios');
    }
};
