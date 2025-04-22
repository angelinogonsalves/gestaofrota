<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoDeProduto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'tipo_de_movimentacao',
        'quantidade',
        'valor_unitario',
        'valor_total',
        'data_atualizacao',
        'produto_id',
        'user_id',
        'responsavel_retirada',
        'responsavel_recebimento',
    ];

    /**
     * produto
     * - 1 movimentação de produto pode ser de 1 produto
     *
     * @return BelongsTo
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }

    /**
     * local
     * - 1 movimentação de caixa pode ser de 1 carga
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
