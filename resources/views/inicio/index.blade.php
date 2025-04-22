@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-boxes"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Produtos</span>
                    <span class="info-box-number">
                        {{ $produtos->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-briefcase"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Funcionários</span>
                    <span class="info-box-number">
                        {{ $funcionarios->count() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-car"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Veículos</span>
                    <span class="info-box-number">
                        {{ $veiculos->count() }} 
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-wrench"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Manutenções</span>
                    <span class="info-box-number">
                        {{ $manutencoes->count() }} 
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->tipo_usuario == 1)
        @include('inicio.frota')
    @endif
    
    @if (auth()->user()->tipo_usuario == 2)
        @include('inicio.financeiro')
    @endif

@endsection
