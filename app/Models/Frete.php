<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Frete extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'data_carregamento',
        'data_saida',
        'data_chegada',
        'peso',
        'valor_tonelada',
        'valor_total',
        'km_saida',
        'km_chegada',
        'distancia',
        'comissao',
        'observacao',
        'espessura',
        'local_origem_id',
        'local_destino_id',
        'local_empresa_id',
        'veiculo_id',
        'funcionario_cortador_id',
        'funcionario_carregador_id',
    ];

    /**
     * localDestino
     * - 1 frete pode ser de 1 local de destino
     *
     * @return BelongsTo
     */
    public function localDestino(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_destino_id');
    }

    /**
     * localOrigem
     * - 1 frete pode ser de 1 local de origem
     *
     * @return BelongsTo
     */
    public function localOrigem(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_origem_id');
    }

    /**
     * localEmpresa
     * - 1 frete pode ser de 1 local de origem
     *
     * @return BelongsTo
     */
    public function localEmpresa(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_empresa_id');
    }

    /**
     * veiculo
     * - 1 frete pode ser de 1 veiculo
     *
     * @return BelongsTo
     */
    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }

    /**
     * funcionarioCortador
     * - 1 frete pode ter de 1 funcionario cortador
     *
     * @return BelongsTo
     */
    public function funcionarioCortador(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_cortador_id');
    }

    /**
     * funcionarioCarregador
     * - 1 frete pode ter de 1 funcionario carregador
     *
     * @return BelongsTo
     */
    public function funcionarioCarregador(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_carregador_id');
    }
}
