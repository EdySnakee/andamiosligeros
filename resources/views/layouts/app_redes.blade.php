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

    /* ESTILOS DE MENÚ COMPACTO E HÍBRIDO (ANIMACIÓN SUAVE + ACCESOS RÁPIDOS + GRUPOS CONSOLIDADOS) */
    @media (min-width: 768px) {
        #accordionSidebar {
            width: 14.5rem !important;
            min-width: 14.5rem !important;
            transition: width 0.28s cubic-bezier(0.4, 0, 0.2, 1), min-width 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }
        #accordionSidebar.toggled {
            width: 6.5rem !important;
            min-width: 6.5rem !important;
        }
    }
    #accordionSidebar .sidebar-brand {
        order: -2;
    }
    /* Cuando el sidebar está desplegado, colocar el botón de la flechita hasta arriba para que nunca sea desplazado */
    #accordionSidebar:not(.toggled) .sidebar-toggler-container {
        order: -1;
        padding: 0.45rem 0 0.2rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        margin-bottom: 0.2rem;
    }
    #accordionSidebar:not(.toggled) #sidebarToggle {
        margin-bottom: 0.15rem;
    }
    #accordionSidebar:not(.toggled) .sidebar-divider-bottom-toggler {
        display: none !important;
    }
    #accordionSidebar .collapsing {
        transition: height 0.26s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    #accordionSidebar .nav-item .nav-link {
        padding: 0.52rem 0.85rem !important;
        position: relative;
        width: 100% !important;
        line-height: 1.35 !important;
        box-sizing: border-box !important;
        white-space: nowrap;
        transition: padding 0.24s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.15s ease;
    }
    #accordionSidebar.toggled .nav-item .nav-link {
        padding: 0.48rem 0.35rem !important;
        text-align: center;
        width: 6.5rem !important;
    }
    #accordionSidebar .nav-item .nav-link i {
        line-height: 1.2 !important;
        transition: font-size 0.22s ease, margin 0.22s ease;
    }
    #accordionSidebar .nav-item .nav-link span {
        line-height: 1.3 !important;
        transition: font-size 0.22s ease;
    }
    #accordionSidebar .sidebar-heading {
        padding: 0 0.75rem;
        font-size: 0.62rem !important;
        line-height: 1.3 !important;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }
    #accordionSidebar.toggled .sidebar-heading {
        text-align: center;
        padding: 0 0.25rem;
        font-size: 0.58rem !important;
    }
    /* Bloque de Accesos Rápidos (Frecuentes / Fijados) */
    #contenedor-accesos-rapidos-sidebar .nav-item-rapido .nav-link {
        padding: 0.42rem 0.85rem !important;
        background: rgba(255, 255, 255, 0.06);
        border-left: 3px solid transparent;
        margin: 3px 6px;
        border-radius: 5px;
        width: calc(100% - 12px) !important;
        transition: background 0.15s ease, border-color 0.15s ease, padding 0.24s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #accordionSidebar.toggled #contenedor-accesos-rapidos-sidebar .nav-item-rapido .nav-link {
        padding: 0.42rem 0.25rem !important;
        margin: 3px 4px;
        width: calc(6.5rem - 8px) !important;
    }
    #contenedor-accesos-rapidos-sidebar .nav-item-rapido .nav-link:hover {
        background: rgba(255, 255, 255, 0.16);
        border-left-color: #f2bc1c;
    }
    #contenedor-accesos-rapidos-sidebar .nav-item-rapido.active .nav-link {
        background: rgba(255, 255, 255, 0.22);
        border-left-color: #f2bc1c;
        font-weight: 700;
    }
    .pin-badge-rapido {
        position: absolute;
        top: 2px;
        right: 3px;
        font-size: 0.62rem !important;
        color: #f2bc1c !important;
        opacity: 0.95;
        padding: 3px 5px;
        border-radius: 4px;
        cursor: pointer;
        z-index: 5;
        transition: transform 0.15s ease, background-color 0.15s ease, color 0.15s ease;
    }
    .pin-badge-rapido:hover {
        background-color: rgba(0, 0, 0, 0.28);
        color: #ffe082 !important;
        transform: scale(1.18);
    }
    /* Submenús con botón de fijar (Pin) */
    #accordionSidebar .collapse-inner .item-menu-pinneable {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        padding: 0.42rem 0.75rem !important;
        margin: 0 0.35rem 2px 0.35rem !important;
        white-space: nowrap;
    }
    .btn-pin-acceso {
        color: #b7b9cc;
        font-size: 0.72rem;
        padding: 2px 5px;
        margin-left: 8px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-pin-acceso:hover {
        color: #1a4189;
        background: #eaecf4;
    }
    .btn-pin-acceso.fijado {
        color: #d99b00;
        background: #fff6d6;
    }
  </style>
</head>

<body id="page-top" class="sidebar-toggled">
  <!-- Page Wrapper -->
    <div id="wrapper">

    <!-- Menú izquierdo -->
    @include('app_redes.includes.menu_izquierdo')
    <!-- Fin de Menú izquierdo -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Menu superior -->
        @include('app_redes.includes.menu_top')
        <!-- Fin de Menu superior -->

        <!-- Begin Page Content -->
        @yield('content')
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      {{--@include('app_redes.includes.notificaciones')--}}
      @include('app_redes.includes.footer')
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cerrar sesión?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
              <a class="btn btn-primary" href="{{url('logout')}}">Cerrar sesión</a>
            </div>
          </div>
        </div>
    </div>

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
  $(document).ready(function() {
      var $sidebar = $('#accordionSidebar');
      var $body = $('body');
      var actual = window.location.href + '';
      var pathname = window.location.pathname + '';
      var split = pathname.split("/");
      var ultima_ruta = split[split.length - 1];

      // 1. Asegurar que al cargar tras cualquier redirección el menú inicie en modo compacto
      $body.addClass('sidebar-toggled');
      $sidebar.addClass('toggled');
      $sidebar.find('.collapse').collapse('hide');

      // 2. Resaltado de módulo y subopción activa según la ruta actual
      switch (ultima_ruta) {
        case 'genera-cotizacion':
            $('#cotizador_m').addClass('active');
            $('#genera_cotizacion').addClass('active');
        break;
        case 'cotizaciones':
            $('#cotizador_m').addClass('active');
            $('#ver_cotizaciones').addClass('active');
        break;
        case 'ventas':
            $('#cotizador_m').addClass('active');
            $('#ver_ventas').addClass('active');
        break;
        case 'clientes':
            $('#cotizador_m').addClass('active');
            $('#todos_clientes_menu').addClass('active');
        break;
        case 'est-ventas':
            $('#cotizador_m').addClass('active');
            $('#ver_est_ventas').addClass('active');
        break;
        case 'est-cotizaciones':
            $('#cotizador_m').addClass('active');
            $('#ver_est_cotizaciones').addClass('active');
        break;
        case 'ordenes-taller':
            $('#taller').addClass('active');
            $('#ver_ordenes_taller').addClass('active');
        break;
        case 'rastreo-guias':
            $('#taller').addClass('active');
            $('#rastreo_guias').addClass('active');
        break;
        case 'inventario':
            $('#taller').addClass('active');
            $('#inventario_menu').addClass('active');
        break;
        case 'ordenes-embarque':
            $('#taller').addClass('active');
            $('#ordenes_embarque_menu').addClass('active');
        break;
        case 'inventarioSuc':
            $('#taller').addClass('active');
            $('#inventarioSuc').addClass('active');
        break;
        case 'productos':
            $('#productos_m').addClass('active');
            $('#ver_productos').addClass('active');
        break;
        case 'agregar-producto':
            $('#productos_m').addClass('active');
            $('#add_producto').addClass('active');
        break;
        case 'productos-tienda':
            $('#productos_m').addClass('active');
            $('#all_tienda_menu').addClass('active');
        break;
        case 'ajustes_tienda':
            $('#productos_m').addClass('active');
            $('#ajustes_tienda').addClass('active');
        break;
        case 'all-promos':
            $('#productos_m').addClass('active');
            $('#all_promo_menu').addClass('active');
        break;
        case 'articulos':
            $('#productos_m').addClass('active');
            $('#todos_articulos_menu').addClass('active');
        break;
        case 'agregar-articulos':
            $('#productos_m').addClass('active');
            $('#agregar_articulos_menu').addClass('active');
        break;
        case 'caja':
            $('#item_usuarios').addClass('active');
            $('#cajaChica').addClass('active');
        break;
        case 'usuarios':
            $('#item_usuarios').addClass('active');
            $('#todos_usuarios_menu').addClass('active');
        break;
        case 'registros-usuarios':
            $('#item_usuarios').addClass('active');
            $('#registros_usuarios_menu').addClass('active');
        break;
        case 'codificar':
            $('#item_usuarios').addClass('active');
            $('#codificar_menu').addClass('active');
        break;
        case 'dashboard':
            $('#dashboard').addClass('active');
        break;
      }

      if (actual.indexOf('/sb-admin/formatos/entrega') !== -1) {
          $('#formatos_m').addClass('active');
          $('#formato_entrega_menu').addClass('active');
      } else if (actual.indexOf('/sb-admin/formatos/cambio-producto') !== -1) {
          $('#formatos_m').addClass('active');
          $('#formato_cambio_menu').addClass('active');
      }

      // 3. Sistema de Accesos Rápidos (Opciones por defecto del rol + Fijados manuales hasta arriba, sin reacomodo automático)
      var userId = $sidebar.attr('data-user-id') || '0';
      var storageKey = 'al_quick_access_v3_' + userId;
      var catalogo = [];
      var defaultsRol = [];
      var maxItems = 4;

      try {
          catalogo = JSON.parse($sidebar.attr('data-catalogo-accesos') || '[]');
          defaultsRol = JSON.parse($sidebar.attr('data-defaults-accesos') || '[]');
      } catch (e) {
          catalogo = [];
          defaultsRol = [];
      }

      var mapaCatalogo = {};
      for (var i = 0; i < catalogo.length; i++) {
          mapaCatalogo[catalogo[i].key] = catalogo[i];
      }

      var claveVistaActual = null;
      for (var j = 0; j < catalogo.length; j++) {
          var itemCat = catalogo[j];
          if (pathname.indexOf(itemCat.match) !== -1) {
              claveVistaActual = itemCat.key;
              break;
          }
      }

      function leerEstadoAccesos() {
          var base = { pinned: [] };
          try {
              var raw = localStorage.getItem(storageKey);
              if (raw) {
                  var parsed = JSON.parse(raw);
                  if (parsed && typeof parsed === 'object' && Array.isArray(parsed.pinned)) {
                      var vistos = {};
                      var limpios = [];
                      for (var i = 0; i < parsed.pinned.length && limpios.length < maxItems; i++) {
                          var k = parsed.pinned[i];
                          if (mapaCatalogo[k] && !vistos[k]) {
                              limpios.push(k);
                              vistos[k] = true;
                          }
                      }
                      base.pinned = limpios;
                  }
              }
          } catch (e) {}
          return base;
      }

      function guardarEstadoAccesos(state) {
          try {
              localStorage.setItem(storageKey, JSON.stringify(state));
          } catch (e) {}
      }

      function obtenerTopAccesosRapidos(state) {
          var seleccionados = [];
          var usados = {};

          // A) Primero los fijados manualmente por el usuario (el último fijado queda hasta arriba en posición #1)
          for (var p = 0; p < state.pinned.length && seleccionados.length < maxItems; p++) {
              var kPin = state.pinned[p];
              if (mapaCatalogo[kPin] && !usados[kPin]) {
                  seleccionados.push({
                      item: mapaCatalogo[kPin],
                      pinned: true
                  });
                  usados[kPin] = true;
              }
          }

          // B) Rellenar los lugares restantes con las opciones por defecto del rol en su orden fijo
          for (var d = 0; d < defaultsRol.length && seleccionados.length < maxItems; d++) {
              var kDef = defaultsRol[d];
              if (mapaCatalogo[kDef] && !usados[kDef]) {
                  seleccionados.push({
                      item: mapaCatalogo[kDef],
                      pinned: false
                  });
                  usados[kDef] = true;
              }
          }

          // C) Respaldo en caso de que el rol tenga menos de 4 defaults definidos
          for (var c = 0; c < catalogo.length && seleccionados.length < maxItems; c++) {
              var kCat = catalogo[c].key;
              if (!usados[kCat]) {
                  seleccionados.push({
                      item: catalogo[c],
                      pinned: false
                  });
                  usados[kCat] = true;
              }
          }

          return seleccionados;
      }

      function renderizarAccesosRapidos() {
          var state = leerEstadoAccesos();
          var topItems = obtenerTopAccesosRapidos(state);
          var $contenedor = $('#contenedor-accesos-rapidos-sidebar');
          var esCompacto = $sidebar.hasClass('toggled');
          var html = '';

          for (var k = 0; k < topItems.length; k++) {
              var entry = topItems[k];
              var it = entry.item;
              var esActivo = (claveVistaActual === it.key) ? 'active' : '';
              var textoMostrar = esCompacto ? it.label : it.full;
              var pinBadge = entry.pinned
                  ? '<i class="fas fa-thumbtack pin-badge-rapido" data-key="' + it.key + '" title="Clic para desfijar"></i>'
                  : '';

              html += '<li class="nav-item nav-item-rapido ' + esActivo + '">' +
                        '<a class="nav-link nav-link-directo" href="' + it.url + '" title="' + it.full + (entry.pinned ? ' (Fijado)' : '') + '">' +
                          pinBadge +
                          '<i class="' + it.icon + '"></i>' +
                          '<span>' + textoMostrar + '</span>' +
                        '</a>' +
                      '</li>';
          }

          $contenedor.html(html);

          // Actualizar estado visual de los pines dentro de los submenús
          $('.btn-pin-acceso').each(function() {
              var kBtn = $(this).attr('data-key');
              if (state.pinned.indexOf(kBtn) !== -1) {
                  $(this).addClass('fijado').attr('title', 'Quitar de fijados');
              } else {
                  $(this).removeClass('fijado').attr('title', 'Fijar hasta arriba en Frecuentes');
              }
          });
      }

      renderizarAccesosRapidos();

      // Fijar (se coloca hasta arriba en posición #1) o desfijar (desde el submenú o directo desde el pin del botón rápido)
      $(document).on('click', '.btn-pin-acceso, .pin-badge-rapido', function(e) {
          e.preventDefault();
          e.stopPropagation();
          var key = $(this).attr('data-key');
          if (!key) return;

          var state = leerEstadoAccesos();
          var idxPin = state.pinned.indexOf(key);
          if (idxPin !== -1) {
              // Desfijar vista
              state.pinned.splice(idxPin, 1);
          } else {
              // Fijar vista hasta arriba (posición #1), desplazando las previas un lugar hacia abajo
              state.pinned.unshift(key);
              if (state.pinned.length > maxItems) {
                  state.pinned = state.pinned.slice(0, maxItems);
              }
          }
          guardarEstadoAccesos(state);
          renderizarAccesosRapidos();
      });

      // 4. Al hacer clic en una categoría con submenú mientras el sidebar está compacto, desplegar el sidebar automáticamente
      $(document).on('click', '#accordionSidebar .nav-link-con-submenu', function(e) {
          if ($sidebar.hasClass('toggled')) {
              e.preventDefault();
              e.stopPropagation();
              var targetSelector = $(this).attr('data-target');
              $body.removeClass('sidebar-toggled');
              $sidebar.removeClass('toggled');
              renderizarAccesosRapidos();
              if (targetSelector) {
                  $sidebar.find('.collapse').not(targetSelector).collapse('hide');
                  $(targetSelector).collapse('show');
              }
          }
      });

      // Al alternar con el botón inferior #sidebarToggle, refrescar etiquetas cortas/largas de Accesos Rápidos
      $('#sidebarToggle, #sidebarToggleTop').on('click', function() {
          setTimeout(renderizarAccesosRapidos, 50);
      });

      // Si el usuario hace clic en el área de trabajo mientras el menú está desplegado, volver a modo compacto
      $('#content-wrapper').on('click', function() {
          if (!$sidebar.hasClass('toggled') && $(window).width() >= 768) {
              $sidebar.find('.collapse').collapse('hide');
              $body.addClass('sidebar-toggled');
              $sidebar.addClass('toggled');
              renderizarAccesosRapidos();
          }
      });
  });
  </script>

  @if(session('error_permiso'))
  <script>
    $(document).ready(function() {
      swal({
        title: "Acceso Restringido",
        text: "{{ session('error_permiso') }}",
        icon: "warning",
        button: "Entendido",
      });
    });
  </script>
  @endif

  @yield('js')


</body>

</html>
