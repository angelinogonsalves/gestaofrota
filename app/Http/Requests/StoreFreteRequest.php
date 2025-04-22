<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFreteRequest extends FormRequest
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
            'data_carregamento' => 'nullable',
            'data_saida' => 'nullable',
            'data_chegada' => 'nullable',
            'peso' => 'nullable',
            'valor_tonelada' => 'nullable',
            'valor_total' => 'nullable',
            'km_saida' => 'nullable',
            'km_chegada' => 'nullable',
            'distancia' => 'nullable',
            'espessura' => 'nullable',
            'observacao' => 'nullable',
            'comissao' => 'nullable',
            'veiculo_id' => 'nullable|integer',
            'local_origem_id' => 'nullable|integer',
            'local_destino_id' => 'nullable|integer',
            'funcionario_cortador_id' => 'nullable|integer',
            'funcionario_carregador_id' => 'nullable|integer',
        ];
    }
}
