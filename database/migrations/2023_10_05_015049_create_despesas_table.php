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
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->nullable();
            $table->string('empresa')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->date('data')->nullable();
            $table->timestamps();
            $table->foreignId('veiculo_id')->constrained();
            $table->foreignId('tipo_despesa_id')->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
