<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesa extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'valor',
        'data',
        'veiculo_id',
        'tipo_despesa_id',
        'empresa',
    ];

    /**
     * tipoDespesa
     * - 1 despesa pode ser de 1 tipo de despesa
     *
     * @return BelongsTo
     */
    public function tipoDespesa(): BelongsTo
    {
        return $this->belongsTo(TipoDespesa::class);
    }

    /**
     * Veiculo
     * - 1 despesa pode ser de 1 veiculo
     *
     * @return BelongsTo
     */
    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }
}
