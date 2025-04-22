<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caixa extends BaseModel
{
    use HasFactory;

    const ENTRADA = '1';
    const SAIDA = '2';
    
    const TIPO_MOVIMENTACAO = [
        self::ENTRADA => "ENTRADA",
        self::SAIDA => "SAIDA",
    ];

    protected $fillable = [
        'saldo',
        'data_atualizacao',
        'local_id',
    ];   

    /**
     * local
     * - 1 caixa pode ser de 1 local
     *
     * @return BelongsTo
     */
    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class);
    }

    /**
     * MovimentacaoDeCaixa
     * - 1 caixa pode ter várias movimentações de caixa
     *
     * @return Hasmany
     *
     */
    public function movimentacaoDeCaixa() :HasMany
    {
        return $this->hasMany(MovimentacaoDeCaixa::class);
    }
}
