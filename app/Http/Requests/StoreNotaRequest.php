<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotaRequest extends FormRequest
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
            'descricao' => 'nullable',
            'empresa' => 'nullable',
            'nota' => 'nullable',
            'boleto' => 'nullable',
            'valor' => 'nullable',
            'vencimento' => 'nullable',
            'pagamento' => 'nullable',
            'pago' => 'nullable',
            'observacao' => 'nullable',
            'emissao' => 'nullable',
            'imposto' => 'nullable',
        ];
    }
}
