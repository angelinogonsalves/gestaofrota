<?php

namespace App\Models;

use App\Http\Services\LoggerService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class BaseModel extends Model
{
    use SoftDeletes;

    public $monthNames = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            Log::info('Evento creating disparado para ' . get_class($model));
        });

        // Aqui onde será feito o log de tudo que for alterado no sistema
        static::saved(function (Model $model) {
            Log::info('Evento saved disparado para ' . get_class($model));
            $userId = auth()->check() ? auth()->id() : null;
            LoggerService::logChanges($model, $userId, $model->wasRecentlyCreated ? 'created' : 'updated');
        });

        // Aqui onde será feito o log de tudo que for deletado no sistema
        static::deleted(function (Model $model) {
            $userId = auth()->check() ? auth()->id() : null;
            LoggerService::logChanges($model, $userId, 'deleted');
        });

    }

    /**
     * competences
     *
     * @param int $numberOfMonths número de meses
     * @return array
     */
    public function competences(int $numberOfMonths = 12)
    {
        $month = date('m');
        $year = date('Y');

        $competences[$year . $month] = $this->monthNames[$month - 1] . '/' . $year;

        for ($i=1; $i < $numberOfMonths; $i++) {

            $previousMonth =  $this->previousMonth($month);

            if ($previousMonth > $month) {
                $year--;
            }

            $competences[$year . $previousMonth] = $this->monthNames[$previousMonth - 1] . '/' . $year;

            $month = $previousMonth;
        }
    
        return $competences;
    }

    /**
     * previousMonth
     * 
     * @param int $month numero do mês atual
     * @return int $month new novo mês
     */
    public function previousMonth(int $month)
    {
        $month--;
        // se o mês for menor que zero, então adicionamos 12 para reiniciar a partir do último
        if ($month <= 0) {
            $month += 12;
        }
        // ajusta para ter sempre duas casas no mês
        return str_pad($month, 2, '0', STR_PAD_LEFT);
    }
}
