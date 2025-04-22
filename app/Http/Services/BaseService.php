<?php

namespace App\Http\Services;

class BaseService {

    /**
     * convertStringToFloat
     * Converte uma string no formato '10.000,51' em um valor de ponto flutuante (float) 10000.51.
     *
     * @param string $value A string a ser convertida.
     * @return float O valor de ponto flutuante convertido.
     */
    public static function convertStringToFloat(string $value = null)
    {
        if (is_null($value)) {
            return $value;
        }
        
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

}
