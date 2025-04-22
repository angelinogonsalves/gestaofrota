@extends('layout.app')

@section('title', 'Relatório')

@section('content')
    <table id="movimentacoesPdf" class="table table-bordered">
        <caption></caption>
        <thead>
            <tr>
                <th>Tipo de Movimentação</th>
                <th>Conta</th>
                <th>Cliente</th>
                <th>Fornecedor</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th>Pagamento</th>
                <th>Pago</th>
            </tr>
        </thead>
        <tbody>
            @forelse($collection as $item)
                <tr>
                    <td>{{ $item->tipo_de_movimentacao_descrita }}</td>
                    <td>{{ $item->conta }}</td>
                    <td>{{ @$item->cliente }}</td>
                    <td>{{ @$item->fornecedor }}</td>
                    <td>@money($item->valor)</td>
                    <td>@date($item->vencimento)</td>
                    <td>@date($item->pagamento)</td>
                    <td>{{ $item->statusPagamento }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Não há dados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection