<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nota extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'nota',
        'empresa',
        'boleto',
        'valor',
        'imposto',
        'emissao',
        'vencimento',
        'pagamento',
        'pago',
        'observacao',
    ];

    /**
     * traz o status atual do pagamento
     *
     * @return void
     */
    public function getStatusPagamentoAttribute()
    {
        return $this->pago ? 'PAGO' : 'AGUARDANDO PAGAMENTO';
    }

    /**
     * traz a classe de acordo com o status atual do pagamento
     *
     * @return void
     */
    public function getClasseStatusPagamentoAttribute()
    {
        return $this->pago ? 'success' : 'warning';
    }

}
