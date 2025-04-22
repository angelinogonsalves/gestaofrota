<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVeiculoRequest extends FormRequest
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
            'nome' => 'required|max:100',
            'placa' => 'required|max:8',
            'km_atual' => 'nullable',
            'ipva_total' => 'nullable',
            'seguro_total' => 'nullable',
            'km_prox_motor' => 'nullable',
            'km_prox_caixa' => 'nullable',
            'km_prox_diferencial' => 'nullable',
            'chassi' => 'nullable',
            'ano' => 'nullable',
            'km_atualizacao' => 'nullable|timestamp',
            'tipo_veiculo_id' => 'nullable|integer',
            'funcionario_id' => 'nullable|integer',
        ];
    }
}
