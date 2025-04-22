<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    const VIEW_NAME = 'relatorios';

    /**
     * Lista geral do relatório de veículos
     */
    public function index(Request $request)
    {
        $startDate = $request->data_inicio ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->data_fim ?? now()->format('Y-m-d');

        $collection = Veiculo::with(['funcionario', 'fretes', 'abastecimentos', 'despesas'])
                            ->select('veiculos.id', 'veiculos.placa', 'veiculos.funcionario_id')
                            ->when($request->placa !== null, function ($query) use ($request) {
                                return $query->where('veiculos.placa', 'LIKE', '%' . $request->placa . '%');
                            })
                            ->get()
                            ->map(function ($veiculo) use ($startDate, $endDate) {
                                if ($veiculo->funcionario) {
                                    $veiculo->motorista = $veiculo->funcionario->nome;
                                }
                                if ($veiculo->fretes) {
                                    $veiculo->valor_producao    = $veiculo->fretes
                                                                ->whereBetween('data_saida', [$startDate, $endDate])
                                                                ->sum('valor_total');
                                    $veiculo->quantidade_fretes = $veiculo->fretes
                                                                ->whereBetween('data_saida', [$startDate, $endDate])
                                                                ->count();
                                    $veiculo->peso_transportado = $veiculo->fretes
                                                                ->whereBetween('data_saida', [$startDate, $endDate])
                                                                ->sum('peso');
                                    $veiculo->valor_comissao    = $veiculo->fretes
                                                                ->whereBetween('data_saida', [$startDate, $endDate])
                                                                ->sum('comissao');
                                }
                                if ($veiculo->abastecimentos) {
                                    $veiculo->quantidade_combustivel = $veiculo->abastecimentos
                                                                ->whereBetween('data', [$startDate, $endDate])
                                                                ->sum('litros');
                                    $veiculo->valor_combustivel = $veiculo->abastecimentos
                                                                ->whereBetween('data', [$startDate, $endDate])
                                                                ->sum('valor_total');
                                    $veiculo->km_rodado         = $veiculo->abastecimentos
                                                                ->whereBetween('data', [$startDate, $endDate])
                                                                ->sum('km_percorrido');
                                }
                                if ($veiculo->despesas) {
                                    $veiculo->valor_despesas    = $veiculo->despesas
                                                                ->whereBetween('data', [$startDate, $endDate])
                                                                ->sum('valor');
                                }
                                return $veiculo;
                            });

        return view(self::VIEW_NAME . '.index', compact('collection', 'startDate', 'endDate', 'request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Request $request, $id)
    {
        $startDate = $request->data_inicio ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->data_fim ?? now()->format('Y-m-d');

        $item = Veiculo::with(['tipoVeiculo', 'funcionario', 'fretes', 'abastecimentos', 'despesas', 'despesas.tipoDespesa', 'ordemDeServicos'])
                        ->find($id);

        $item->load(['fretes' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('data_saida', [$startDate, $endDate])->orderBy('data_saida');
        }]);
    
        $item->load(['despesas' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('data', [$startDate, $endDate]);
        }]);

        $item->load(['abastecimentos' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('data', [$startDate, $endDate])->orderBy('data');
        }]);

        $item->load(['ordemDeServicos' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('data_fim', [$startDate, $endDate]);
        }]);

        // Inicializar os totais
        $item->total_km_percorrido = 0;
        $item->total_litros = 0;
        $item->total_media_consumo = 0;

        // Calcular os totais
        foreach ($item->abastecimentos as $abastecimentoAtual) {
            // Adicionar ao total de km percorrido
            $item->total_km_percorrido += $abastecimentoAtual->km_percorrido;
            // Adicionar ao total de litros (apenas se o km percorrido for maior que 0)
            $item->total_litros += ($item->total_km_percorrido > 0) ? $abastecimentoAtual->litros : 0;
        }

        // Calcular a média de consumo (apenas se o total de km percorrido for maior que 0)
        $item->total_media_consumo = ($item->total_km_percorrido > 0) ? ($item->total_km_percorrido / $item->total_litros) : 0;

        return view(self::VIEW_NAME . '.show', compact('item', 'startDate', 'endDate', 'request'));
    }
}
