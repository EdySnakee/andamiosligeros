<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ url('script/img/icono-app-andamios.png') }}" type="image/x-icon">
    <title>Andamios Ligeros | Panel Administrativo</title>
    <!-- Custom fonts for this template-->
    <link href="{{ url('script/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ url('script/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script>
        var URL_BASE_WEB = '<?php echo url("/"); ?>';
    </script>
    @yield('css')
</head>
<body class="login-page-body">
    <div class="login-main-wrapper">
        @yield('content')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ url('script/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('script/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('script/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('script/js/sb-admin-2.min.js') }}"></script>
    @yield('js')
</body>
</html>