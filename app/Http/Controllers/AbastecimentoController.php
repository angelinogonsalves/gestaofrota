<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Http\Requests\StoreAbastecimentoRequest;
use App\Http\Services\BaseService;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbastecimentoController extends Controller
{
    protected Abastecimento $model;
    
    const VIEW_NAME = 'abastecimentos';

    public function __construct(Abastecimento $abastecimento)
    {
        $this->model = $abastecimento;
    }

    /**
     * abre tela de listagem dos abastecimentos
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if(!$request->filtro_competencia) {
            $request->offsetSet('filtro_competencia', now()->format('Ym'));
        }

        $collection = $this->model->select('abastecimentos.*', 'veiculos.placa', 'tipo_veiculos.tipo_usuario_responsavel')
                    ->join('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->join('tipo_veiculos', 'tipo_veiculos.id', 'veiculos.tipo_veiculo_id')
                    ->when($request->filtro_competencia > 0, function ($query) use ($request) {
                        return $query->where(DB::RAW("date_format(data, '%Y%m')"), $request->filtro_competencia);
                    })
                    ->when($request->filtro_placa, function ($query) use ($request) {
                        return $query->where('veiculos.placa', 'LIKE', '%' . $request->filtro_placa . '%');
                    })
                    // função para filtrar o veiculo pelo perfil do usuario
                    ->when(function ($query) {
                        $query->where(function ($query) {
                            $query->where('tipo_veiculos.tipo_usuario_responsavel', auth()->user()->tipo_usuario)
                                  ->orWhereNull('tipo_veiculos.tipo_usuario_responsavel');
                        });
                    })
                    ->orderBy('data', 'DESC')
                    ->orderBy('veiculos.placa', 'ASC')
                    ->get();
        
        $competences = $this->model->competences();

        return view(self::VIEW_NAME.'.index', compact('collection', 'request', 'competences'));
    }

    /**
     * abre tela de edição / cadastro do abastecimento
     *
     * @param Abastecimento $abastecimento
     * @return void
     */
    public function edit(Request $request, Abastecimento $abastecimento)
    {
        $tipoCombustiveis = ['DIESEL', 'ETANOL', 'GASOLINA'];
        $veiculos = Veiculo::orderBy('placa')->get();

        return view(self::VIEW_NAME.'.edit',
            ['item' => $abastecimento, 'veiculos' => $veiculos, 'tipoCombustiveis' => $tipoCombustiveis, 'request' => $request]);
    }

    /**
     * salva os dados do abastecimento
     *
     * @param StoreAbastecimentoRequest $request
     * @param Abastecimento $abastecimento
     * @return void
     */
    public function store(StoreAbastecimentoRequest $request, Abastecimento $abastecimento)
    {
        $data = $request->only('combustivel', 'veiculo_id', 'data', 'descricao', 'local_abastecimento');
       
        $data['valor_total'] = BaseService::convertStringToFloat($request->valor_total);
        $data['valor_unitario'] = BaseService::convertStringToFloat($request->valor_unitario);
        $data['litros'] = BaseService::convertStringToFloat($request->litros);
        $data['km'] = BaseService::convertStringToFloat($request->km);

        $abastecimento->fill($data);

        if (!$abastecimento->save($data)) {
            return $this->responseError();
        }

        if ($abastecimento->km > $abastecimento->veiculo->km_atual) {
            $abastecimento->veiculo->km_atual = $abastecimento->km;
            $abastecimento->veiculo->km_atualizacao = $abastecimento->data;
            $abastecimento->veiculo->save();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o abastecimento
     *
     * @param Abastecimento $abastecimento
     * @return void
     */
    public function destroy(Request $request, Abastecimento $abastecimento)
    {
        if (!$abastecimento->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }
}
