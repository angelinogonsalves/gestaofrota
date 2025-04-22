<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends BaseModel
{
    use HasFactory;

    const ENTRADA = '1';
    const SAIDA = '2';
    
    const TIPO_MOVIMENTACAO = [
        self::ENTRADA => "ENTRADA",
        self::SAIDA => "SAIDA",
    ];

    protected $fillable = [
        'nome',
        'unidade_de_medida',
        'quantidade_em_estoque',
        'valor_unitario',
        'valor_total',
        'data_atualizacao',
        'codigo_de_barras',
    ];

    /**
     * MovimentacaoDeProduto
     * - 1 Produto pode ter várias movimentações de Produto
     *
     * @return Hasmany
     *
     */
    public function movimentacaoDeProduto() :HasMany
    {
        return $this->hasMany(MovimentacaoDeProduto::class);
    }
}
