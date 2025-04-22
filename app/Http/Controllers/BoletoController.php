<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoletoRequest;
use App\Http\Services\BaseService;
use App\Models\Boleto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoletoController extends Controller
{
    protected Boleto $model;

    const VIEW_NAME = 'boletos';

    public function __construct(Boleto $boleto)
    {
        $this->model = $boleto;
    }

    /**
     * abre tela de listagem dos boletos
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if(!$request->filtro_competencia) {
            $request->offsetSet('filtro_competencia', now()->format('Ym'));
        }

        // Verifica o tipo de usuário logado, User::CONTAS é o gerencial
        if ($user->tipo_usuario == User::CONTAS) {
            // Se o usuário for do tipo 3, filtra os boletos onde o user associado é do tipo 3
            $collection = $this->model->whereHas('user', function ($query) {
                $query->where('tipo_usuario', User::CONTAS);
            })
            ->when($request->filtro_competencia > 0, function ($query) use ($request) {
                return $query->where(DB::RAW("date_format(vencimento, '%Y%m')"), $request->filtro_competencia);
            })
            ->when($request->filtro_situacao == 'AGUARDANDO PAGAMENTO', function ($query) use ($request) {
                return $query->where('pago', false);
            })
            ->when($request->filtro_situacao == 'PAGO', function ($query) use ($request) {
                return $query->where('pago', true);
            })
            ->get();
        } else {
            // Caso contrário, retorna todos os boletos, incluindo os que têm user_id nulo
            $collection = $this->model->where(function ($query) {
                $query->whereNull('user_id')
                    ->orWhereHas('user', function ($subQuery) {
                        $subQuery->where('tipo_usuario', '!=', User::CONTAS);
                    });
            })
            ->when($request->filtro_competencia > 0, function ($query) use ($request) {
                return $query->where(DB::RAW("date_format(vencimento, '%Y%m')"), $request->filtro_competencia);
            })
            ->when($request->filtro_situacao == 'AGUARDANDO PAGAMENTO', function ($query) use ($request) {
                return $query->where('pago', false);
            })
            ->when($request->filtro_situacao == 'PAGO', function ($query) use ($request) {
                return $query->where('pago', true);
            })
            ->orderBy('vencimento')
            ->get();
        }
        
        $competences = $this->model->competences();

        return view(self::VIEW_NAME . '.index', compact('collection', 'request', 'competences'));
    }

    /**
     * abre tela de edição / cadastro do Boleto
     *
     * @param Boleto $boleto
     * @return void
     */
    public function edit(Boleto $boleto)
    {
        $collection = Boleto::where('descricao', $boleto->descricao)->orderBy('vencimento')->get();

        return view(self::VIEW_NAME . '.edit', ['item' => $boleto, 'collection' => $collection]);
    }

    /**
     * salva os dados da nota
     *
     * @param StoreBoletoRequest $request
     * @param Boleto $boleto
     * @return void
     */
    public function store(StoreBoletoRequest $request, Boleto $boleto)
    {
        $data = $request->only('descricao', 'boleto', 'parcela', 'vencimento');

        $data['valor'] = BaseService::convertStringToFloat($request->valor ?? 0);
        $data['user_id'] = auth()->user()->id;
        
        $boleto->fill($data);

        if (!$boleto->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * faz o pagamento do boleto, altera seu status para pago
     *
     * @param StoreBoletoRequest $request
     * @param Boleto $boleto
     * @return void
     */
    public function pay(StoreBoletoRequest $request, Boleto $boleto)
    {
        $data = $request->only('pago');

        $data['pagamento'] = now();
        
        $boleto->fill($data);

        if (!$boleto->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o Boleto
     *
     * @param Boleto boleto
     * @return void
     */
    public function destroy(Boleto $boleto)
    {
        if (!$boleto->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * verifica se boleto existe
     * 
     * @param Request $request
     * @return json $return
     */
    public function checkBoleto(Request $request)
    {
        $user = auth()->user();
        $boletoNumber = $request->input('boleto');

        // Verifica o tipo de usuário logado
        if ($user->tipo_usuario == User::CONTAS) {
            // Filtra boletos onde o user associado é do tipo CONTAS
            $exists = $this->model::where('boleto', $boletoNumber)
                            ->whereHas('user', function ($query) {
                                $query->where('tipo_usuario', User::CONTAS);
                            })->exists();
        } else {
            // Verifica se o boleto existe, considerando outros tipos de usuários
            $exists = $this->model::where('boleto', $boletoNumber)
                            ->where(function ($query) {
                                $query->whereNull('user_id')
                                    ->orWhereHas('user', function ($subQuery) {
                                        $subQuery->where('tipo_usuario', '!=', User::CONTAS);
                                    });
                            })->exists();
        }

        return response()->json(['exists' => $exists]);
    }
}
