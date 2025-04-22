<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-print-2.3.6/datatables.min.css"/>
        @stack('styles')       
    </head>

    <body class="hold-transition sidebar-mini">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="wrapper">
            @include('partials.header')
            @include('partials.sidebar')
            <div class="content-wrapper">
                <div class="content">
                    <div class="container-fluid">
                        @include('partials.messages')
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('partials.footer')
        </div>

        <script>const baseUrl = "{{ url('/') }}";</script>
        <script>const datatableLangUrl = "{{ asset('plugins/datatables/datatable-pt-BR.json') }}";</script>
        <script>var filter = @json(@$request ? $request?->filter : '');</script>
        
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/croppie.js') }}"></script>
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-print-2.3.6/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('/js/adminlte.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/functions.js?v15') }}"></script>
        <script src="{{ asset('js/custom.js?v15') }}"></script>
        @stack('scripts')
    </body>
</html>
