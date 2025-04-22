<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conta extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'saldo',
        'data_atualizacao',
    ];

    /**
     * Define a relação de uma conta com suas movimentações.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoDeConta::class);
    }
}
