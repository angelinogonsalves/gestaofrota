<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoVeiculoRequest extends FormRequest
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
            'faz_frete' => 'nullable',
            'prox_troca_oleo_motor' => 'nullable',
            'prox_troca_oleo_caixa' => 'nullable',
            'prox_troca_oleo_diferencial' => 'nullable',
            'tipo_usuario_responsavel' => 'nullable',
        ];
    }
}
