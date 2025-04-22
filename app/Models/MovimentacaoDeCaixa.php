<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoDeCaixa extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'tipo_de_movimentacao',
        'valor',
        'motivo',
        'data_movimentacao',
        'caixa_id',
        'user_id',
    ];

    /**
     * local
     * - 1 movimentação de caixa pode ser de 1 caixa
     *
     * @return BelongsTo
     */
    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class);
    }

    /**
     * local
     * - 1 movimentação de caixa pode ser de 1 carga
     *
     * @return BelongsTo
     */
    public function carga(): BelongsTo
    {
        return $this->belongsTo(Frete::class, 'frete_id', 'id');
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
