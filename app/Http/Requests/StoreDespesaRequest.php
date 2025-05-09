<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDespesaRequest extends FormRequest
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
            'valor' => 'nullable',
            'data' => 'nullable',
            'veiculo_id' => 'nullable|integer',
            'tipo_despesa_id' => 'nullable|integer',
        ];
    }
}
