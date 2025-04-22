<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestão Frota | Inicio </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
        >
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/login" class="h1"><b>Gestão Frota</b></a>
                </div>
                <div class="card-body">

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif

                    @if ($errors)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}</div>
                        @endforeach
                    @endif
                        
                    <p class="login-box-msg">Entre com seu e-mail e senha</p>
                    <form action="{{ url('loga') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control"
                                placeholder="Email" value="{{ old('email') }}"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input name="password" type="password" class="form-control" placeholder="Senha">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary btn-block" value="Entrar"/>
                            </div>
                        </div>
                    </form>
                    <br>
                    <p class="mb-1">
                        <a href="{{url('/recuperar-senha')}}">Esqueci minha senha</a>
                    </p>
                </div>
            </div>
        </div>

        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('/js/adminlte.js') }}"></script>

    </body>
</html>
