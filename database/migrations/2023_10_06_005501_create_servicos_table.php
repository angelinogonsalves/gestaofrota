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
        Schema::create('ordem_de_servicos', function (Blueprint $table) {
            $table->id();
            $table->text('problema')->nullable();
            $table->text('solucao')->nullable();
            $table->text('observacao')->nullable();
            $table->date('data_solicitacao')->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->decimal('valor_produtos', 10, 2)->nullable();
            $table->decimal('valor_mao_de_obra', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->timestamps();
            $table->foreignId('veiculo_id')->constrained();
            $table->tinyInteger('troca_oleo_motor')->nullable();
            $table->tinyInteger('troca_oleo_caixa')->nullable();
            $table->tinyInteger('troca_oleo_diferencial')->nullable();
            $table->decimal('km_oleo_motor', 10, 1)->nullable();
            $table->decimal('km_oleo_caixa', 10, 1)->nullable();
            $table->decimal('km_oleo_diferencial', 10, 1)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordem_de_servicos');
    }
};
