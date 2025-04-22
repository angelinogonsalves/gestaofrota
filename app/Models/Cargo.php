<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    /**
     * funcionarios
     * - 1 cargo pode estar para vários funcionários
     *
     * @return HasMany
     */
    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionario::class);
    }
}
