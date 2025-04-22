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
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="../../index2.html" class="h1"><b>Gestão Frota</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Esqueceu sua senha? Informe seu e-mail para recuperar senha.</p>
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                            </div>
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="{{ url('/login') }}">Volar para Login</a>
                    </p>
                </div>
            </div>
        </div>

        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('/js/adminlte.js') }}"></script>

    </body>

</html>
