<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light"> Gestão Frota </span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/perfil.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>

            <div class="info">
                <a href="#" class="d-block">
                    <span class="badge badge-primary">
                        {{ auth()->user()->nome }}
                    </span>
                </a>
            </div>
        </div>

        <nav class="mt-2" aria-label="" aria-labelledby="">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">Cadastros</li>
                <li class="nav-item">
                    <a href="{{ url('/usuarios') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Usuários</p>
                    </a>
                </li>

                @if (auth()->user()->isGerencial())
                    <li class="nav-header">Gestão de Contas</li>
                    <li class="nav-item">
                        <a href="{{ url('/movimentacoes/dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/movimentacoes') }}" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>Movimentações Geral</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/movimentacoes/diarias') }}" class="nav-link">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>Movimentações diárias</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/contas') }}" class="nav-link">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Contas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/clientes') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Clientes</p>
                        </a>
                    </li>       
                    <li class="nav-item">
                        <a href="{{ url('/fornecedores-funcionarios') }}" class="nav-link">
                            <i class="nav-icon fas fa-building"></i>
                            <span>Fornecedores / Funcionários</span>
                        </a>
                    </li>
                @endif
                
                @if (auth()->user()->isFinanceiro() || auth()->user()->isGerencial())
                    <li class="nav-header">Financeiro</li>
                    <li class="nav-item">
                        <a href="{{ url('/caixas') }}" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>Caixas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/notas') }}" class="nav-link">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p>Notas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/boletos') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Boletos</p>
                        </a>
                    </li>
                @endif
                
                @if (auth()->user()->isFrota())
                    <li class="nav-header">Pessoas</li>
                    <li class="nav-item">
                        <a href="{{ url('/cargos') }}" class="nav-link">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Cargos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/funcionarios') }}" class="nav-link">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Funcionários</p>
                        </a>
                    </li>

                    <li class="nav-header">Estoque</li>
                    <li class="nav-item">
                        <a href="{{ url('/produtos') }}" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Produtos</p>
                        </a>
                    </li>

                    <li class="nav-header">Veículos</li>
                    <li class="nav-item">
                        <a href="{{ url('/tipo-veiculos') }}" class="nav-link">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Tipos de Veículos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/veiculos') }}" class="nav-link">
                            <i class="nav-icon fas fa-car"></i>
                            <p>Veículos</p>
                        </a>
                    </li>

                    <li class="nav-header">Fretes</li>
                    <li class="nav-item">
                        <a href="{{ url('/locais') }}" class="nav-link">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>Locais</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/fretes') }}" class="nav-link">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Fretes</p>
                        </a>
                    </li>

                    <li class="nav-header">Despesas</li>
                    <li class="nav-item">
                        <a href="{{ url('/tipo-despesas') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Tipos de Despesas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/despesas') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Despesas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/abastecimentos') }}" class="nav-link">
                            <i class="nav-icon fas fa-gas-pump"></i>
                            <p>Abastecimentos</p>
                        </a>
                    </li>

                    <li class="nav-header">Manutençao</li>
                    <li class="nav-item">
                        <a href="{{ url('/ordens-de-servicos') }}" class="nav-link">
                            <i class="nav-icon fas fa-wrench"></i>
                            <p>Ordens de Serviços</p>
                        </a>
                    </li>

                    <li class="nav-header">Relatórios</li>
                    <li class="nav-item">
                        <a href="{{ url('/relatorios') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Geral</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>