
@extends('layout.app')

@section('title', 'Despesas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span>
                        Despesas
                    </span>
                    <a href="{{ url('despesas/cadastro') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Despesas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                
                <div class="card-header">
                    <form action="{{ url('despesas') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="filtro_placa">
                                    Placa:
                                </label>
                                <input type="text" class="form-control" id="filtro_placa" name="filtro_placa"
                                    value="{{ old('filtro_placa', $request->filtro_placa)}}" placeholder="Informe..">
                            </div>
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="filtro_competencia">
                                    Competência:
                                </label>
                                <select name="filtro_competencia" id="filtro_competencia" class="form-control">
                                    <option value="-1">--</option>
                                    @foreach ($competences as $competence => $competenceName)
                                        <option value="{{ $competence }}"
                                            @if (old('filtro_competencia', $request->filtro_competencia) == $competence)
                                                selected=""
                                            @endif >
                                            {{ $competenceName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <button class="btn btn-info" type="submit">
                                    <i class="fas fa-search"></i>
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive p-2">
                    <table id="despesas" class="table table-bordered table-hover table-datatable">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Placa do Veículo</th>
                                <th>Tipo de Despesa</th>
                                <th>Descrição</th>
                                <th>Empresa</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>@date($item->data)</td>
                                    <td>{{ $item->placa }}</td>
                                    <td>{{ $item->tipo_despesa }}</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td>{{ $item->empresa }}</td>
                                    <td>@money($item->valor)</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('despesas/cadastro', [$item->id]) . '?' . $request->getQueryString() }}">
                                            <i class="fas fa-edit"> </i> Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center">Não há dados</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
