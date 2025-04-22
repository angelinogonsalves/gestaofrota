<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdemDeServicoProduto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'quantidade',
        'valor_total',
        'valor_unitario',
        'produto_id',
        'ordem_de_servico_id',
    ];

    /**
     * OrdemDeServico
     * - 1 produto pode pertencer a um serviço
     *
     * @return BelongsTo
     */
    public function ordemDeServico(): BelongsTo
    {
        return $this->belongsTo(OrdemDeServico::class);
    }

    /**
     * produto
     * - 1 produto da ordem de serviço pode ser de 1 produto
     *
     * @return BelongsTo
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}
