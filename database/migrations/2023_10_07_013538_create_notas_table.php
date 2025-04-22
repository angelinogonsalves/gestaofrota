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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->nullable();
            $table->string('empresa')->nullable();
            $table->string('nota')->nullable();
            $table->string('boleto')->nullable();
            $table->string('nota')->nullable();
            $table->string('observacao', 255)->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->decimal('imposto', 10, 2)->nullable();
            $table->date('emissao')->nullable();
            $table->date('vencimento')->nullable();
            $table->date('pagamento')->nullable();
            $table->boolean('pago')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
