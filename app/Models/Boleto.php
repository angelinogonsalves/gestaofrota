<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boleto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'boleto',
        'parcela',
        'valor',
        'vencimento',
        'pagamento',
        'pago',
        'user_id',
    ];
    
    /**
     * Usuário
     * - 1 boleto pode ser de 1 usuario
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * traz o status atual do pagamento
     *
     * @return string
     */
    public function getStatusPagamentoAttribute()
    {
        return $this->pago ? 'PAGO' : 'AGUARDANDO PAGAMENTO';
    }

    /**
     * traz a classe de acordo com o status atual do pagamento
     *
     * @return string
     */
    public function getClasseStatusPagamentoAttribute()
    {
        return $this->pago ? 'success' : 'warning';
    }

    /**
     * traz a classe se estiver vencido
     *
     * @return string
     */
    public function getClasseStatusVencimentoAttribute()
    {
        if ($this->pago || !$this->vencimento) {
            return '';
        }

        $vencimento = new DateTime($this->vencimento);
        $hoje = new DateTime();

        if ($vencimento->format('Ymd') < $hoje->format('Ymd')) {
            return 'danger';
        }

        if ($vencimento->format('Ymd') == $hoje->format('Ymd')) {
            return 'warning';
        }

        return '';
    }

}
