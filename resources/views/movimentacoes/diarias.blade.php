
@extends('layout.app')

@section('title', 'Movimentações')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Movimentações diárias</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Movimentações diárias</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive p-2">
                    <table id="movimentacoes" class="table table-bordered table-hover">
                        <caption>Movimentações diárias</caption>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Entradas</th>
                                <th>Saídas</th>
                                <th>Boletos Pagos</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resultados as $item)
                                <tr>
                                    <td>@date($item['date'])</td>
                                    <td>
                                        <b>Total: @money($item['total_entrada'])<br></b>
                                        Boleto: @money($item['total_entrada_boleto'])<br>
                                        Dinheiro: @money($item['total_entrada_dinheiro'])<br>
                                        Cheque: @money($item['total_entrada_cheque'])<br>
                                        Pix: @money($item['total_entrada_pix'])<br>
                                        Débito em Conta: @money($item['total_entrada_debito'])<br>
                                        Não Definido: @money($item['total_entrada_indefinido'])
                                    </td>
                                    <td>
                                        <b>Total: @money($item['total_saida'])<br></b>
                                        Boleto: @money($item['total_saida_boleto'])<br>
                                        Dinheiro: @money($item['total_saida_dinheiro'])<br>
                                        Cheque: @money($item['total_saida_cheque'])<br>
                                        Pix: @money($item['total_saida_pix'])<br>
                                        Débito em Conta: @money($item['total_saida_debito'])<br>
                                        Não Definido: @money($item['total_saida_indefinido'])
                                    </td>
                                    <td>@money($item['total_boletos_pago'])</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('movimentacoes') }}?{{ http_build_query(['filtro_competencia' => -1, 'filtro_data' => $item['date'] ?? -1]) }}">
                                            <i class="fas fa-show"> </i> ver movimentações
                                        </a>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('boletos') . '?filter=' . $item['date'] }}">
                                            <i class="fas fa-show"> </i> ver boletos
                                        </a>
                                    </td>
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
        </div>
    </section>
@endsection
