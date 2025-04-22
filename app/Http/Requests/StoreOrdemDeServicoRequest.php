<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdemDeServicoRequest extends FormRequest
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
            'problema' => 'nullable',
            'solucao' => 'nullable',
            'data_solicitacao' => 'nullable',
            'data_inicio' => 'nullable',
            'data_fim' => 'nullable',
            'valor_produtos' => 'nullable',
            'valor_mao_de_obra' => 'nullable',
            'valor_total' => 'nullable',
            'veiculo_id' => 'nullable',
            'troca_oleo_motor' => 'nullable',
            'troca_oleo_caixa' => 'nullable',
            'troca_oleo_diferencial' => 'nullable',
            'km_oleo_motor' => 'nullable',
            'km_oleo_caixa' => 'nullable',
            'km_oleo_diferencial' => 'nullable',
            'observacao' => 'nullable',
        ];
    }
}
