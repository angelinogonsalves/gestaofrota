<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdemDeServico extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'problema',
        'solucao',
        'data_solicitacao',
        'data_inicio',
        'data_fim',
        'valor_produtos',
        'valor_mao_de_obra',
        'valor_total',
        'veiculo_id',
        'troca_oleo_motor',
        'troca_oleo_caixa',
        'troca_oleo_diferencial',
        'km_oleo_motor',
        'km_oleo_caixa',
        'km_oleo_diferencial',
        'observacao',
    ];

    /**
     * OrdemDeServicoProduto
     * - 1 Ordem de serviço pode ter várias produtos
     *
     * @return Hasmany
     *
     */
    public function ordemDeServicoProduto() :HasMany
    {
        return $this->hasMany(OrdemDeServicoProduto::class);
    }
    
    /**
     * OrdemDeServicoFuncionario
     * - 1 Ordem de serviço pode ter várias funcionários
     *
     * @return Hasmany
     *
     */
    public function ordemDeServicoFuncionario() :HasMany
    {
        return $this->hasMany(OrdemDeServicoFuncionario::class);
    }

    /**
     * veiculo
     * - 1 Ordem de serviço pode ser para 1 veiculo
     *
     * @return BelongsTo
     */
    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }
}
