<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const FROTA = 1;
    const FINANCEIRO = 2;
    const CONTAS = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'tipo_usuario',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
      
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * confere se é permetido acessar e manipular dados da frota
     */
    public function isFrota()
    {
        return $this->isFinanceiro() || $this->tipo_usuario == self::FROTA;
    }
    
    /**
     * confere se é permetido acessar e manipular dados do financeiro
     */
    public function isFinanceiro()
    {
        return $this->tipo_usuario == self::FINANCEIRO;
    }

    /**
     * confere se é permetido acessar e manipular dados das contas e movimentações
     */
    public function isGerencial()
    {
        return $this->tipo_usuario == self::CONTAS;
    }
}
