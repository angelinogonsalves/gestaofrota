
<div id="frota">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Frota</h3>
        </div>
        <div class="card-body table-responsive p-2">
            <div class="row">
                @forelse ($veiculos as $item)
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header text-center bg-{{ $item->classeStatusProxTroca }}"">
                                {{ $item->placa }}
                            </div>
                            <div class="card-body">
                                <table class="table-light">
                                    <tbody>
                                        <tr>
                                            <th>KM atual:</th>
                                            <td>@km($item->km_atual)</td>
                                        </tr>
                                        <tr class="table-{{ $item->classeKmProxMotor }}">
                                            <th>Próx. troca de óleo do motor:</th>
                                            <td>@km($item->km_prox_motor)</td>
                                        </tr>
                                        <tr class="table-{{ $item->classeKmProxCaixa }}">
                                            <th>Próx. troca de óleo da caixa:</th>
                                            <td>@km($item->km_prox_caixa)</td>
                                        </tr>
                                        <tr class="table-{{ $item->classeKmProxDiferencial }}">
                                            <th>Próx. troca de óleo do diferencial:</th>
                                            <td>@km($item->km_prox_diferencial)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <span>Atualizado em @date($item->km_atualizacao)</span>
                                <a class="btn float-right badge" href="{{ url('veiculos/cadastro', [$item->id]) }}">
                                    <i class="fas fa-edit"> </i> Editar
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    
                @endforelse
            </div>
        </div>
    </div>
</div>
