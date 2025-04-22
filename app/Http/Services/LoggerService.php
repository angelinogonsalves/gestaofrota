<?php

namespace App\Http\Services;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

class LoggerService
{
    public static function logChanges(Model $model, $userId, $action)
    {
        $log = new Log();
        $log->user_id = $userId; // ID do usuário que fez a alteração
        $log->data = now(); // Data atual
        $log->tabela = $model->getTable(); // Obtém o nome da tabela do modelo
        $log->tabela_id = $model->id; // Obtém o id da tabela do modelo
        $log->antes = $action !== 'created' ? json_encode($model->getOriginal()) : null; // Dados antes da alteração

        if ($action === 'deleted') {
            // Se o registro foi excluído, armazene os dados antes da exclusão
            $log->depois = null;
        } else {
            // Para atualizações ou criações, armazene os dados após a alteração
            $log->depois = json_encode($model->getAttributes());
        }

        $log->save();
    }
}
