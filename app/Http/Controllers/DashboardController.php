<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoDeConta;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Carrega os dados para o gráfico do fluxo de caixa
     * 
     * @return json $dadosFluxoCaixa
     */
    public function getDadosFluxoCaixa()
    {
        $collectionFluxoCaixa = MovimentacaoDeConta::select(
            DB::raw('YEAR(pagamento) as ano'),
            DB::raw('MONTH(pagamento) as mes'),
            DB::raw('SUM(CASE WHEN tipo_de_movimentacao = "1" THEN valor ELSE 0 END) as total_entradas'),
            DB::raw('SUM(CASE WHEN tipo_de_movimentacao = "2" THEN valor ELSE 0 END) as total_saidas')
        )
            ->whereNotNull('pagamento')
            ->groupBy(DB::raw('YEAR(pagamento)'), DB::raw('MONTH(pagamento)'))
            ->get();

        $dadosFluxoCaixa = [];
        foreach ($collectionFluxoCaixa as $item) {
            $mes_ano = \Carbon\Carbon::createFromDate($item->ano, $item->mes)->format('M Y');
            $dadosFluxoCaixa[$mes_ano]['Entradas'] = $item->total_entradas;
            $dadosFluxoCaixa[$mes_ano]['Saídas'] = $item->total_saidas;
        }

        return response()->json($dadosFluxoCaixa);
    }

    /**
     * Carrega os dados para o gráfico de despesas semanais
     * 
     * @return json $dadosDespesasSemanais
     */
    public function getDadosDespesasSemanais()
    {
        $collectionDespesasSemanais = MovimentacaoDeConta::select(
            DB::raw('YEARWEEK(pagamento, 1) as semana'),
            DB::raw('SUM(CASE WHEN tipo_de_movimentacao = "2" THEN valor ELSE 0 END) as total_saidas')
        )
            ->whereNotNull('pagamento')
            ->groupBy(DB::raw('YEARWEEK(pagamento, 1)'))
            ->get();

        $dadosDespesasSemanais = [];
        foreach ($collectionDespesasSemanais as $item) {
            $dadosDespesasSemanais[$item->semana] = $item->total_saidas;
        }

        return response()->json($dadosDespesasSemanais);
    }

    /**
     * Carrega os dados para o gráfico de distribuição de contas
     * 
     * @return json $dadosDistribuicaoContas
     */
    public function getDadosDistribuicaoContas()
    {
        $collectionDistribuicaoContas = MovimentacaoDeConta::select('motivo', DB::raw('sum(valor) as total'))
            ->groupBy('motivo')
            ->where('tipo_de_movimentacao', MovimentacaoDeConta::SAIDA)
            ->whereNotNull('pagamento')
            ->get();

        $totalContasPagas = $collectionDistribuicaoContas->sum('total');

        $dadosDistribuicaoContas = [];
        foreach ($collectionDistribuicaoContas as $item) {
            $percentual = round(($item->total / $totalContasPagas) * 100);
            $dadosDistribuicaoContas[$item->motivo] = $percentual;
        }

        arsort($dadosDistribuicaoContas);

        return response()->json($dadosDistribuicaoContas);
    }
}
