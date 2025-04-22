<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
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
            'nome' => 'max:100',
            'unidade_de_medida' => 'max:100',
            'quantidade_em_estoque' => 'nullable',
            'valor_unitario' => 'nullable',
            'valor_total' => 'nullable',
            'data_atualizacao' => 'nullable',
            'codigo_de_barras' => 'nullable',
        ];
    }
}
