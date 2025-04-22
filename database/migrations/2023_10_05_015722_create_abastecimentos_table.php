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
        Schema::create('abastecimentos', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->decimal('km', 10, 1)->nullable();
            $table->decimal('litros', 10, 3)->nullable();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->string('combustivel')->comment('ETANOL', 'GASOLINA', 'DIESEL');
            $table->string('descricao')->nullable();
            $table->string('local_abastecimento')->nullable();
            $table->timestamps();
            $table->foreignId('veiculo_id')->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abastecimentos');
    }
};
