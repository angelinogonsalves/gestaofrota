
@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span>
                        Dashboard
                    </span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">                
                <div class="card-header">
                    <h1>
                        Gráficos de movimentações
                    </h1>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="movimentacaoMensal" height="500px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="despesasSemanais" height="500px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="distribuicaoContas" height="500px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
    
@push('scripts')
    <script src="{{ asset('js/dashboards/movimentacaoMensal.js') }}"></script>
    <script src="{{ asset('js/dashboards/despesasSemanais.js') }}"></script>
    <script src="{{ asset('js/dashboards/distribuicaoContas.js') }}"></script>
@endpush
