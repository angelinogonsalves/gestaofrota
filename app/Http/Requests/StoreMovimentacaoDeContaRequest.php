<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimentacaoDeContaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer',
            'tipo_de_movimentacao' => 'nullable|integer',
            'pagamento' => 'nullable',
            'valor' => 'nullable',
            'motivo' => 'nullable',
            'tipo_pagamento' => 'nullable',
            'conta_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'cliente_id' => 'nullable|integer',
            'fornecedor_id' => 'nullable|integer',
            'arquivo_pdf' => 'nullable|mimes:pdf',
        ];
    }
}
