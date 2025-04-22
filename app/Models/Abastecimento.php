<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Abastecimento extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'valor_total',
        'valor_unitario',
        'km',
        'data',
        'combustivel',
        'litros',
        'veiculo_id',
        'descricao',
        'local_abastecimento',
    ];

    /**
     * Veiculo
     * - 1 abastecimento pode ser de 1 veiculo
     *
     * @return BelongsTo
     */
    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }
    
    /**
     * traz o km anterior, do último abastecimento
     *
     * @return void
     */
    public function getKmAnteriorAttribute()
    {
        if (!$this->veiculo_id || !$this->km || $this->km <= 0) {
            return 0;
        }

        $anterior = Abastecimento::where('veiculo_id', $this->veiculo_id)
                                ->where('id', '<>', $this->id)
                                ->where('data', '<=', $this->data)
                                ->orderBy('data', 'DESC')
                                ->limit('1')
                                ->first();
                
        if (!$anterior || !$anterior->km || $anterior->km <= 0) {
            return 0;
        }

        return $anterior->km;
    }
    /**
     * traz o km percorrido, desde o ultimo abastecimento até ao atual
     *
     * @return void
     */
    public function getKmPercorridoAttribute()
    {
        if (!$this->km || $this->km <= 0 || !$this->km_anterior || $this->km_anterior <= 0) {
            return 0;
        }

        return $this->km - $this->km_anterior;
    }

    /**
     * traz a média de consumo, desde o ultimo abastecimento até ao atual
     *
     * @return void
     */
    public function getMediaConsumoAttribute()
    {
        if (!$this->km_percorrido || $this->km_percorrido <= 0) {
            return 0;
        }

        return $this->km_percorrido / $this->litros;
    }
}
