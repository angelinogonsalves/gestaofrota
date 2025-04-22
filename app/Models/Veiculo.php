<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Veiculo extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'placa',
        'km_atual',
        'km_atualizacao',
        'tipo_veiculo_id',
        'funcionario_id',
        'ipva_total',
        'seguro_total',
        'km_prox_motor',
        'km_prox_caixa',
        'km_prox_diferencial',
        'chassi',
        'ano',
    ];

    /**
     * tipoVeiculo
     * - 1 veiculo pode ser de 1 tipo de veiculo
     *
     * @return BelongsTo
     */
    public function tipoVeiculo(): BelongsTo
    {
        return $this->belongsTo(TipoVeiculo::class);
    }

    /**
     * funcionario
     * - 1 veiculo pode ter 1 funcionario motorista
     *
     * @return BelongsTo
     *
     */
    public function funcionario() :BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    /**
     * veiculos
     * - 1 veiculo pode estar para vários fretes
     *
     * @return Hasmany
     *
     */
    public function fretes() :HasMany
    {
        return $this->hasMany(Frete::class);
    }

    /**
     * veiculos
     * - 1 veiculo pode estar para vários abastecimentos
     *
     * @return Hasmany
     *
     */
    public function abastecimentos() :HasMany
    {
        return $this->hasMany(Abastecimento::class);
    }

    /**
     * despesas
     * - 1 veiculo pode estar para várias despesas
     *
     * @return Hasmany
     *
     */
    public function despesas() :HasMany
    {
        return $this->hasMany(Despesa::class);
    }

    /**
     * veiculos
     * - 1 veiculo pode estar para várias ordens de servicos
     *
     * @return Hasmany
     *
     */
    public function ordemDeServicos() :HasMany
    {
        return $this->hasMany(OrdemDeServico::class);
    }
    
    /**
     * traz a classe de acordo com o km da próxima troca em comparação com o atual
     *
     * @return string
     */
    public function getclasseKmProxMotorAttribute()
    {
        return $this->km_prox_motor <= $this->km_atual ? 'danger' : '';
    }
    
    /**
     * traz a classe de acordo com o km da próxima troca em comparação com o atual
     *
     * @return string
     */
    public function getclasseKmProxCaixaAttribute()
    {
        return $this->km_prox_caixa <= $this->km_atual ? 'danger' : '';
    }
    
    /**
     * traz a classe de acordo com o km da próxima troca em comparação com o atual
     *
     * @return string
     */
    public function getclasseKmProxDiferencialAttribute()
    {
        return $this->km_prox_diferencial <= $this->km_atual ? 'danger' : '';
    }

    /**
     * traz a classe de acordo com o km da próxima troca em comparação com o atual
     *
     * @return string
     */
    public function getclasseStatusProxTrocaAttribute()
    {
        if ($this->km_prox_motor <= $this->km_atual) {
            return 'danger';
        }
        if ($this->km_prox_caixa <= $this->km_atual) {
            return 'danger';
        }
        if ($this->km_prox_diferencial <= $this->km_atual) {
            return 'danger';
        }
        return '';
    }

    public static function proxTrocaOleoMotor($veiculo_id = null)
    {
        if (!$veiculo_id) {
            return TipoDespesa::PROX_TROCA_OLEO_MOTOR;
        }

        $veiculo = Veiculo::with('tipoVeiculo')->find($veiculo_id);
        return $veiculo->tipoVeiculo->prox_troca_oleo_motor ?? TipoDespesa::PROX_TROCA_OLEO_MOTOR;
    }

    public static function proxTrocaOleoCaixa($veiculo_id = null)
    {
        if (!$veiculo_id) {
            return TipoDespesa::PROX_TROCA_OLEO_CAIXA;
        }

        $veiculo = Veiculo::with('tipoVeiculo')->find($veiculo_id);
        return $veiculo->tipoVeiculo->prox_troca_oleo_caixa ?? TipoDespesa::PROX_TROCA_OLEO_CAIXA;
    }

    public static function proxTrocaOleoDiferencial($veiculo_id = null)
    {
        if (!$veiculo_id) {
            return TipoDespesa::PROX_TROCA_OLEO_DIFERENCIAL;
        }

        $veiculo = Veiculo::with('tipoVeiculo')->find($veiculo_id);
        return $veiculo->tipoVeiculo->prox_troca_oleo_diferencial ?? TipoDespesa::PROX_TROCA_OLEO_DIFERENCIAL;
    }

}
