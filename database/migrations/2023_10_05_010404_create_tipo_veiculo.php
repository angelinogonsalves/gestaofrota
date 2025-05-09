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
        Schema::create('tipo_veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('faz_frete')->default('0');
            $table->integer('prox_troca_oleo_motor');
            $table->integer('prox_troca_oleo_caixa');
            $table->integer('prox_troca_oleo_diferencial');
            $table->integer('tipo_usuario_responsavel');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_veiculos');
    }
};
