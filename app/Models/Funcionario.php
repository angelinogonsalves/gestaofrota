<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cargo_id',
        'salario',
    ];

    // Acessor para o campo virtual salario_por_hora
    public function getSalarioPorHoraAttribute()
    {
        return $this->salario / TipoDespesa::HORAS_TRABALHO;
    }

    /**
     * cargos
     * - 1 funcionário pode ter 1 cargo
     *
     * @return BelongsTo
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * veiculos
     * - 1 funcionário pode estar em vários veículos
     *
     * @return Hasmany
     *
     */
    public function veiculos() :HasMany
    {
        return $this->hasMany(Veiculo::class);
    }
}
