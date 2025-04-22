<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id',
        'tabela',
        'tabela_id',
        'antes',
        'depois',
        'data',
    ];

    protected $casts = [
        'antes' => 'json',
        'depois' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAcaoAttribute()
    {
        if ($this->antes && $this->depois) {
            return 'Atualizado';
        }
        if ($this->depois) {
            return 'Novo';
        }
        return 'Excluído';
    }

    public function getAntesDecodificadoAttribute()
    {
        return json_decode($this->antes, true);
    }

    public function getDepoisDecodificadoAttribute()
    {
        return json_decode($this->depois, true);
    }
}
