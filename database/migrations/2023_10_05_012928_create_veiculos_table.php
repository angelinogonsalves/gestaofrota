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
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('placa')->unique();
            $table->decimal('ipva_total', 10, 2)->nullable();
            $table->decimal('seguro_total', 10, 2)->nullable();
            $table->decimal('km_atual', 10, 1)->nullable();
            $table->decimal('km_prox_motor', 10, 1)->nullable();
            $table->decimal('km_prox_caixa', 10, 1)->nullable();
            $table->decimal('km_prox_diferencial', 10, 1)->nullable();
            $table->date('km_atualizacao')->nullable();
            $table->string('chassi')->nullable;
            $table->string('ano')->nullable;
            $table->timestamps();
            $table->foreignId('tipo_veiculo_id')->constrained();
            $table->foreignId('funcionario_id')->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
