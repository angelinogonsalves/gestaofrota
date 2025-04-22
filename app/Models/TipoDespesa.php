<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoDespesa extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'calculo',
        'valor_padrao',
    ];

    const IPVA = 1;
    const SEGURO = 2;
    const SALARIO = 3;

    const HORAS_TRABALHO = 200;

    const PROX_TROCA_OLEO_MOTOR = 15000;
    const PROX_TROCA_OLEO_CAIXA = 60000;
    const PROX_TROCA_OLEO_DIFERENCIAL = 80000;

    /**
     * despesas
     * - 1 tipo de despesa pode estar para várias despesas
     *
     * @return HasMany
     */
    public function despesas(): HasMany
    {
        return $this->hasMany(Despesa::class);
    }
}
