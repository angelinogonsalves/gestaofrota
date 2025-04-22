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
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->decimal('saldo', 10, 2)->nullable();
            $table->date('data_atualizacao')->nullable();
            $table->timestamps();
            $table->foreignId('local_id')->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixas');
    }
};
