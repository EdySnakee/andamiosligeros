<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" type="image/x-icon" href="{{ url('web/buen_fin/assets/favicon.ico') }}" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;600&family=Poppins:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;1,700&family=Racing+Sans+One&display=swap" rel="stylesheet">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ url('web/buen_fin/css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{url('web/css/misestilos.css?v=0.4')}}">
        @yield('css')
    </head>
    <body id="page-top">
        <!-- Navigation-->
        {{-- 
            <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#page-top">
                    <img width="200px" src="{{url('web/img/logo-andamios-merida.webp')}}" alt="Venta de andamios ligeros en mexico">
                </a>
                
            </div>
        </nav>
         --}}
        @yield('content')
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container px-4 px-lg-5">Copyright &copy; Andamios Ligeros 2023</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ url('web/buen_fin/js/scripts.js') }}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
