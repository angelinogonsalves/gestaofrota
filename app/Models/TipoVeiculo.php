<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoVeiculo extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'faz_frete',
        'prox_troca_oleo_motor',
        'prox_troca_oleo_caixa',
        'prox_troca_oleo_diferencial',
        'tipo_usuario_responsavel'
    ];

    /**
     * veiculos
     * - 1 tipo de veículo pode estar para vários veículos
     *
     * @return HasMany
     */
    public function veiculos(): HasMany
    {
        return $this->hasMany(Veiculo::class);
    }

    /**
     * podeEditar
     *
     * @return boolean
     */
    public function getFretistaAttribute()
    {
        return $this->faz_frete ? 'Sim' : 'Não';
    }

    public function userTipoIdParaDescricao($tipo = null)
    {
        if (!$tipo) {
            return 'Todos';
        }
        return match ($tipo) {
            1 => 'Frota',
            2 => 'Financeiro',
            3 => 'Gerente de Contas'
        };
    }
}
