
<div id="financeiro">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Boletos Não Pagos</h3>
        </div>
        <div class="card-body table-responsive p-2">
            <table id="tabela_financeiro" class="table table-bordered table-hover">
                <caption></caption>
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Boleto</th>
                        <th>Parcela</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($boletos as $item)
                        <tr>
                            <td>{{ $item->descricao }}</td>
                            <td>{{ $item->boleto }}</td>
                            <td>{{ $item->parcela }}</td>
                            <td>@money($item->valor)</td>
                            <td class="table-{{ $item->classeStatusVencimento }}">@date($item->vencimento)</td>
                            <td>
                                <span class="badge badge-{{ $item->classeStatusPagamento }}">
                                    {{ $item->statusPagamento }}
                                </span>
                            </td>
                            <td class="d-flex">
                                <div class="p-1">
                                    <a class="btn btn-sm btn-primary" href="{{ url('boletos/cadastro', [$item->id]) }}">
                                        <i class="fas fa-edit"> </i> Editar
                                    </a>
                                </div>
                                @if (!$item->pago)
                                    <form class="p-1" action="{{ url('boletos/pagar', [$item->id]) }}" method="post"
                                        onsubmit="return confirm('Tem certeza de que deseja mudar o boleto para PAGO?');">
                                        @csrf
                                        <input type="hidden" name="pago" value="1">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class='fas fa-check'> </i> Mudar para Pago
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Não há dados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
