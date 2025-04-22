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
        Schema::create('ordem_de_servico_produtos', function (Blueprint $table) {
            $table->id();
            $table->decimal('quantidade', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->timestamps();
            $table->foreignId('produto_id')->constrained();
            $table->foreignId('ordem_de_servico_id')->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordem_de_servico_produtos');
    }
};
