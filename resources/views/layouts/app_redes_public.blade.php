<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{url('script/img/icono-app-andamios.png')}}" type="image/x-icon">
  <title>Sistema Andamios Ligeros</title>

  <!-- Custom fonts for this template-->
  <link href="{{url('script/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  


  <link rel="stylesheet" href="{{url('script/dist/bootstrap-tagsinput.css')}}">
  <link href="{{url('script/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{url('script/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{url('script/css/misestilos.css')}}" rel="stylesheet">
  <link href="{{url('script/css/components.css')}}" rel="stylesheet">
  <link href="{{url('script/css/plugins.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{url('script/dropify/dist/css/dropify.min.css')}}">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  @yield('css')
  <style>
    .sidebar .sidebar-brand, .topbar {
        height: 3rem;
    }
    table.dataTable thead .sorting:after {
        top: auto !important;
        font-size: inherit !important;
    }
    table.dataTable thead .sorting:after{
      right: 0.5em !important;
      content: "\2193" !important;
    }
    .ui-datepicker th {
        padding: 0 !important;
    }
    .dataTables_filter {
        position: absolute;
        top: 0;
        right: 0;
    }
    .col-1-5 {
        flex: 0 0 20%;
        max-width: 20%
    }

    .col-2-5 {
        flex: 0 0 40%;
        max-width: 40%
    }

    .col-3-5 {
        flex: 0 0 60%;
        max-width: 60%
    }

    .col-4-5 {
        flex: 0 0 80%;
        max-width: 80%
    }

    @media(min-width:576px) {
        .col-sm-1-5 {
            flex: 0 0 20%;
            max-width: 20%
        }

        .col-sm-2-5 {
            flex: 0 0 40%;
            max-width: 40%
        }

        .col-sm-3-5 {
            flex: 0 0 60%;
            max-width: 60%
        }

        .col-sm-4-5 {
            flex: 0 0 80%;
            max-width: 80%
        }
    }

    @media(min-width:768px) {
        .col-md-1-5 {
            flex: 0 0 20%;
            max-width: 20%
        }

        .col-md-2-5 {
            flex: 0 0 40%;
            max-width: 40%
        }

        .col-md-3-5 {
            flex: 0 0 60%;
            max-width: 60%
        }

        .col-md-4-5 {
            flex: 0 0 80%;
            max-width: 80%
        }
    }

    @media(min-width:992px) {
        .col-lg-1-5 {
            flex: 0 0 20%;
            max-width: 20%
        }

        .col-lg-2-5 {
            flex: 0 0 40%;
            max-width: 40%
        }

        .col-lg-3-5 {
            flex: 0 0 60%;
            max-width: 60%
        }

        .col-lg-4-5 {
            flex: 0 0 80%;
            max-width: 80%
        }
    }

    @media(min-width:1200px) {
        .col-xl-1-5 {
            flex: 0 0 20%;
            max-width: 20%
        }

        .col-xl-2-5 {
            flex: 0 0 40%;
            max-width: 40%
        }

        .col-xl-3-5 {
            flex: 0 0 60%;
            max-width: 60%
        }

        .col-xl-4-5 {
            flex: 0 0 80%;
            max-width: 80%
        }
    }
    .infodata{
        background: #f9f9f9;
        padding: 1rem 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .infodata i{
      position: relative;
      color: #e7e7e7;
      font-size: 5.2rem;
      margin-bottom: 10px;
    }
    .card-big-info-title {
        margin-left: 1em;
    }
    .no-margin {
        margin: 0 !important;
    }
    .boxdata{
      padding: 1rem 2rem;
    }
    .mt-10 {
        margin-top: 1em;
    }
    .card-big-info-title {
        color: #222529;
        font-size: 20.8px;
        font-size: 1.3rem;
        font-weight: 700;
        line-height: 1.2;
        margin: 0 0 10px;
    }
  </style>
</head>

<body id="page-top" style="background-color: #f8f9fc;">
  <!-- Page Wrapper -->
    <div id="wrapper">

    <!-- Menú izquierdo -->
    <!-- Fin de Menú izquierdo -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Menu superior -->
        <!-- Fin de Menu superior -->

        <!-- Begin Page Content -->
        @yield('content')
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer (Removed for TV layout) -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


<div class="modal fade" id="modal_app_redes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" role="document">
      <div class="modal-content">

      </div>
  </div>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{url('script/js/jquery2.js')}}"></script>
  <script src="{{url('script/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{url('script/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{url('script/js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  <?php /*<script src="{{url('script/vendor/chart.js/Chart.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <script src="{{url('script/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{url('script/js/demo/chart-pie-demo.js')}}"></script>
  */ ?>

    <!-- Page level plugins -->
  <script src="{{url('script/vendor/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{url('script/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <?php /*<script src="{{url('script/js/demo/datatables-demo.js')}}"></script>*/ ?>
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js" crossorigin="anonymous"></script>

  <script src="{{url('script/js/custom.js')}}"></script>

  
  <script src="{{url('script/dropify/dist/js/dropify.min.js')}}"></script>
  
  
  <script>
  $( document ).ready(function() {
      //Se obtiene el valor de la URL desde el navegador
      var actual = window.location+'';
      //Se realiza la división de la URL
      var split = actual.split("/");
      //Se obtiene el ultimo valor de la URL
      var ultima_ruta = split[split.length-1];
      //console.log(ultima_ruta);

      switch (ultima_ruta) {
        case 'agregar-estados':
            $('#proyectos_m').addClass('active');
            //$('#proyectos_m > div').addClass('show');
            $('#agregar_proyecto_menu').addClass('active');

            $('#todos_proyecto_menu').removeClass('active');
        break;
        case 'estados':
            $('#proyectos_m').addClass('active');
            //$('#proyectos_m > div').addClass('show');
            $('#todos_proyecto_menu').addClass('active');
            //$('#agregar_proyecto_menu').removeClass('active');
        break;

        case 'agregar-proyectos':
            $('#proyectos_m').removeClass('active');
            //$('#proyectos_m > div').removeClass('show');
            $('#todos_proyecto_menu').removeClass('active');
            $('#agregar_proyecto_menu').removeClass('active');

            $('#clientes_m').addClass('active');
            //$('#clientes_m > div').addClass('show');
            $('#agregar_clientes_menu').addClass('active');
        break;
        case 'proyectos':
            $('#proyectos_m').removeClass('active');
            //$('#proyectos_m > div').removeClass('show');
            $('#todos_proyecto_menu').removeClass('active');
            $('#agregar_proyecto_menu').removeClass('active');

            $('#clientes_m').addClass('active');
            //$('#clientes_m > div').addClass('show');
            $('#todos_proyectos_menu').addClass('active');
        break;
        case 'articulos':
            $('#articulos_m').addClass('active');
            //$('#articulos_m > div').addClass('show');
            $('#todos_articulos_menu').addClass('active');
        break;
        case 'agregar-articulos':
            $('#articulos_m').addClass('active');
            //$('#articulos_m > div').addClass('show');
            $('#agregar_articulos_menu').addClass('active');
        break;

        case 'genera-cotizacion':
            $('#cotizador_m').addClass('active');
            //$('#cotizador_m > div').addClass('show');
            $('#genera_cotizacion').addClass('active');
        break;

        case 'cotizaciones':
            $('#cotizador_m').addClass('active');
            //$('#cotizador_m > div').addClass('show');
            $('#ver_cotizaciones').addClass('active');
        break;

        case 'ventas':
            $('#ventas_m').addClass('active');
            //$('#ventas_m > div').addClass('show');
            $('#ver_ventas').addClass('active');
        break;

        case 'productos':
            $('#productos_m').addClass('active');
            //$('#productos_m > div').addClass('show');
            $('#ver_productos').addClass('active');
        break;

        case 'agregar-producto':
            $('#productos_m').addClass('active');
            //$('#productos_m > div').addClass('show');
            $('#add_producto').addClass('active');
        break;

        case 'productos-tienda':
            $('#tienda_m').addClass('active');
            $('#all_tienda_menu').addClass('active');
        break;

        case 'usuarios':
            $('#item_usuarios').addClass('active');
            //$('#item_usuarios > div').addClass('show');
            $('#todos_usuarios_menu').addClass('active');
        break;
        case 'dashboard':
            $('#dashboard').addClass('active');
        break;
           case 'estadisticas':
            $('#estadisticas').addClass('active');
        break;
         case 'inventario':
            $('#inventario').addClass('active');
        break;
          case 'ordenes-embarque':
            $('#inventario').addClass('active');
        break;
          case 'inventarioSuc':
            $('#inventarioSuc').addClass('active');
        break;
            case 'caja':
            $('#cajaChica').addClass('active');
        break;
      }
  });
  </script>
  @yield('js')


</body>

</html>
