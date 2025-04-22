<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoDeConta extends BaseModel
{
    use HasFactory;

    const ENTRADA = '1';
    const SAIDA = '2';
    
    const TIPO_MOVIMENTACAO = [
        self::ENTRADA => "ENTRADA",
        self::SAIDA => "SAIDA",
    ];

    const TIPO_PAGAMENTO = ['Boleto', 'Dinheiro', 'Cheque', 'Pix', 'Débito em Conta', 'Crédito em Conta'];

    protected $fillable = [
        'pagamento',
        'tipo_de_movimentacao',
        'conta_id',
        'cliente_id',
        'fornecedor_id',
        'valor',
        'motivo',
        'tipo_pagamento',
        'user_id',
        'caminho_arquivo_pdf',
    ];
    
    /**
        * traz a descrição do tipo de movimentação
        *
        * @return string
        */
    public function getTipoDeMovimentacaoDescritaAttribute()
    {
        return $this::TIPO_MOVIMENTACAO[$this->tipo_de_movimentacao];
    }

    /**
     * traz o status atual do pagamento
     *
     * @return string
     */
    public function getOrigemDestinoAttribute()
    {
        if ($this->tipo_de_movimentacao == self::ENTRADA && $this->cliente_id > 0 ) {
            return $this->cliente;
        }
        if ($this->tipo_de_movimentacao == self::SAIDA && $this->fornecedor_id > 0 ) {
            return $this->fornecedor;
        }
        return '';
    }

    /**
     * conta
     * - 1 movimentação de conta pode ser de 1 conta
     *
     * @return BelongsTo
     */
    public function conta(): BelongsTo
    {
        return $this->belongsTo(Conta::class);
    }

    /**
     * cliente
     * - 1 movimentação de conta pode ser de 1 cliente
     *
     * @return BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * fornecedor
     * - 1 movimentação de conta pode ser de 1 fornecedor
     *
     * @return BelongsTo
     */
    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    /**
     * user
     * - 1 movimentação de conta pode ter um usuario que movimentou
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
