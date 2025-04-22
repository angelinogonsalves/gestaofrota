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
        Schema::create('fretes', function (Blueprint $table) {
            $table->id();
            $table->date('data_saida')->nullable();
            $table->date('data_chegada')->nullable();
            $table->date('data_carregamento')->nullable();;
            $table->decimal('peso', 10, 2)->nullable();
            $table->decimal('valor_tonelada', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->decimal('comissao', 10, 2)->nullable();
            $table->decimal('km_saida', 10, 1)->nullable();
            $table->decimal('km_chegada', 10, 1)->nullable();
            $table->decimal('distancia', 10, 1)->nullable();
            $table->string('espessura')->nullable();
            $table->string('observacao')->nullable();
            $table->timestamps();
            $table->foreignId('veiculo_id')->constrained();
            $table->foreignId('local_origem_id')->references('id')->on('locals');
            $table->foreignId('local_destino_id')->references('id')->on('locals');
            $table->foreignId('local_empresa_id')->references('id')->on('locals');
            $table->foreignId('funcionario_cortador_id')->references('id')->on('funcionarios');
            $table->foreignId('funcionario_carregador_id')->references('id')->on('funcionarios');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fretes');
    }
};
