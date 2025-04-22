<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdemDeServicoFuncionario extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'tempo',
        'valor_total',
        'valor_unitario',
        'funcionario_id',
        'ordem_de_servico_id',
    ];

    /**
     * OrdemDeServico
     * - 1 funcionario da ordem de serviço pode pertencer a um serviço
     *
     * @return BelongsTo
     */
    public function ordemDeServico(): BelongsTo
    {
        return $this->belongsTo(OrdemDeServico::class);
    }

    /**
     * Funcionario
     * - 1 funcionario da ordem de serviço pode ser de 1 funcionario
     *
     * @return BelongsTo
     */
    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }
}
