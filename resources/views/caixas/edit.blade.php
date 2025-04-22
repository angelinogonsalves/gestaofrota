
@extends('layout.app')

@section('title', 'Caixas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Caixas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('caixas') }}">Caixas</a></li>
                        <li class="breadcrumb-item active">Cadastro</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Cadastro</h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('caixas/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item->id) }}">
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="form-label">Local do Caixa *</label>
                                <select name="local_id" id="local_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($locais as $local)
                                        <option value="{{ $local->id }}"
                                            @if (old('local_id', $item) == $local->id)
                                                selected=""
                                            @endif >
                                            {{ $local->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Saldo do Caixa *</label>
                                <input type="text" name="saldo" id="saldo"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('saldo', $item) }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Data de Atualização *</label>
                                <input type="date" name="data_atualizacao" id="data_atualizacao" class="form-control"
                                    value="{{ old('data_atualizacao', $item) ?? now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save" aria-hidden="true"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-2">
                            <a href="{{ url('caixas') }}" class="btn btn-info">
                                <i class="fas fa-angle-double-left"></i>
                                Voltar
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('caixas/excluir', $item->id) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-danger"
                                    onclick="if (confirm('Tem certeza de que deseja excluir?')) {
                                        document.getElementById('form_excluir').submit();
                                    }">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            {{-- mostra o histórico de movimentação do caixa --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Histórico</h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table class="table table-bordered table-hover">
                        <thead> 
                            <tr>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Carga</th>
                                <th>Ação</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->movimentacaoDeCaixa as $movimentacao)
                                <tr>
                                    <td>@datetime($movimentacao->data_movimentacao)</td>
                                    <td>{{ @$movimentacao->user->nome }}</td>
                                    <td>{{ @$movimentacao->carga->veiculo->placa }} - @date(@$movimentacao->carga->data_carregamento)</td>
                                    <td>{{ $item::TIPO_MOVIMENTACAO[$movimentacao->tipo_de_movimentacao] }}</td>
                                    <td>@money($movimentacao->valor)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Não há dados</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- LOG NÂO UTILIZADO --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Histórico</h3>
                </div>
                <div class="card-body">
                    @if($logs->isNotEmpty())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Usuário</th>
                                    <th>Ação</th>
                                    <th>Antes</th>
                                    <th>Depois</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log->data }}</td>
                                        <td>{{ $log->user ? $log->user->name : 'N/A' }}</td>
                                        <td>{{ $log->acao }}</td>
                                        <td>
                                            @if($log->antes)
                                                {{ $item::TIPO_MOVIMENTACAO[$log->antesDecodificado['tipo_de_movimentacao']] }} 
                                                de @money($log->antesDecodificado['valor'])
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($log->depois)
                                                {{ $item::TIPO_MOVIMENTACAO[$log->depoisDecodificado['tipo_de_movimentacao']] }} 
                                                de @money($log->depoisDecodificado['valor'])
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">Não há dados</p>
                    @endif
                </div>
            </div> --}}

        </div>
    </section>
    
@endsection
