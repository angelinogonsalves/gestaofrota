<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fornecedor extends BaseModel
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'descricao',
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
