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
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->nullable();
            $table->string('boleto')->nullable();
            $table->string('parcela')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->date('vencimento')->nullable();
            $table->date('pagamento')->nullable();
            $table->boolean('pago')->nullable()->default(false);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletos');
    }
};
