<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('sb-admin/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img width="35px" src="{{ url('script/icono-sistema.png') }}" alt="">
        </div>
        <div class="sidebar-brand-text mx-3" style="color: #0848af;">
            <div>ANDAMIOS</div><small>LIGEROS</small>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard: Visible para todos EXCEPTO t1 --}}
    @if (empty(\Auth::User()->tipo_usuario) || \Auth::User()->tipo_usuario != 't1')
    <li id="dashboard" class="nav-item">
        <a class="nav-link" href="{{ url('sb-admin/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    @endif

    {{-- INTERFASE WEB - Solo Admin --}}
    @if (!empty(\Auth::User()->tipo_usuario) && \Auth::User()->tipo_usuario == 'admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Interfase Web
    </div>

    <li id="articulos_m" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBlog" aria-expanded="true"
            aria-controls="collapseBlog">
            <i class="far fa-newspaper"></i>
            <span>Blog</span>
        </a>
        <div id="collapseBlog" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo de Blog:</h6>
                <a id="todos_articulos_menu" class="collapse-item" href="{{ url('sb-admin/articulos') }}">Todos
                    los artículos</a>
                <a id="agregar_articulos_menu" class="collapse-item"
                    href="{{ url('sb-admin/agregar-articulos') }}">Agregar artículo</a>
            </div>
        </div>
    </li>

    <li id="tienda_m" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTienda" aria-expanded="true"
            aria-controls="collapseTienda">
            <i class="fas fa-store"></i>
            <span>Tienda en Linea</span>
        </a>
        <div id="collapseTienda" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo Tienda en Linea:</h6>
                <a id="all_tienda_menu" class="collapse-item" href="{{ url('sb-admin/productos-tienda') }}"><i
                        class="fas fa-list"></i> Listado de productos</a>
                <a id="ajustes_tienda" class="collapse-item" href="{{ url('sb-admin/ajustes_tienda') }}"><i
                        class="fas fa-cog"></i> Ajustes</a>
            </div>
        </div>
    </li>

    <li id="promo_m" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePromo" aria-expanded="true"
            aria-controls="collapsePromo">
            <i class="fa fa-percent" aria-hidden="true"></i>
            <span>Promociones</span>
        </a>
        <div id="collapsePromo" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo Promociones</h6>
                <a id="all_promo_menu" class="collapse-item" href="{{ url('sb-admin/all-promos') }}"><i
                        class="fas fa-list"></i> Listado de promociones</a>
            </div>
        </div>
    </li>

    <li id="estadisticas" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEstadistica"
            aria-expanded="true" aria-controls="collapseEstadistica">
            <i class="fas fa-chart-bar"></i>
            <span>Estadisticas</span>
        </a>
        <div id="collapseEstadistica" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo de estadisticas:</h6>
                <a id="ver_cotizaciones" class="collapse-item" href="{{ url('sb-admin/est-ventas') }}">Ventas</a>
                <a id="ver_cotizaciones" class="collapse-item"
                    href="{{url('sb-admin/est-cotizaciones')}}">Cotizaciones</a>
            </div>
        </div>
    </li>

    <li id="inventario" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventario"
            aria-expanded="true" aria-controls="collapseInventario">
            <i class="fas fa-boxes"></i>
            <span>Inventario</span>
        </a>
        <div id="collapseInventario" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo Inventario</h6>
                <a id="inventario_menu" class="collapse-item" href="{{ url('sb-admin/inventario') }}"><i
                        class="fas fa-boxes"></i> Inventario</a>
                <a id="ordenes_embarque_menu" class="collapse-item" href="{{ url('sb-admin/ordenes-embarque') }}"><i
                        class="fas fa-list"></i> Ordenes de
                    embarque</a>
            </div>
        </div>
    </li>

    <li id="productos_m" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProductos"
            aria-expanded="true" aria-controls="collapseProductos">
            <i class="fas fa-cube"></i>
            <span>Productos</span>
        </a>
        <div id="collapseProductos" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Catálogo de productos:</h6>
                <a id="ver_productos" class="collapse-item" href="{{ url('sb-admin/productos') }}">Listado de
                    productos</a>
                <a id="add_producto" class="collapse-item" href="{{ url('sb-admin/agregar-producto') }}">Agregar
                    producto</a>
            </div>
        </div>
    </li>
    @endif

    {{-- VENTAS - Visible solo para usuario v1 --}}
    @if (!empty(\Auth::User()->tipo_usuario) && \Auth::User()->tipo_usuario == 'v1')

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Ventas
    </div>

    <li id="cotizador_m" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCotizador"
            aria-expanded="true" aria-controls="collapseCotizador">
            <i class="fas fa-calculator"></i>
            <span>Cotizador</span>
        </a>
        <div id="collapseCotizador" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo de cotizaciones:</h6>
                <a id="ver_cotizaciones" class="collapse-item" href="{{ url('sb-admin/cotizaciones') }}">Listado de
                    cotizaciones</a>
                <a id="genera_cotizacion" class="collapse-item"
                    href="{{ url('sb-admin/genera-cotizacion') }}">COTIZAR</a>
            </div>
        </div>
    </li>

    <li id="ventas_v1" class="nav-item">
        <a class="nav-link" href="{{ url('sb-admin/ventas') }}">
            <i class="fas fa-dollar-sign"></i>
            <span>Ventas</span>
        </a>
    </li>

    @endif

    {{-- TALLER - Visible para Admin y Taller (t1) --}}
    @if (!empty(\Auth::User()->tipo_usuario) && (\Auth::User()->tipo_usuario == 'admin' || \Auth::User()->tipo_usuario == 't1' || \Auth::User()->tipo_usuario == 'v1'))
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Producción
    </div>
    <li id="taller" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTaller" aria-expanded="true"
            aria-controls="collapseTaller">
            <i class="fas fa-tools"></i>
            <span>Taller</span>
        </a>
        <div id="collapseTaller" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Ordenes de taller:</h6>
                <a id="ver_ordenes_taller" class="collapse-item" href="{{ url('sb-admin/ordenes-taller') }}">Listado de
                    ordenes</a>
                <a id="rastreo_guias" class="collapse-item" href="{{ url('sb-admin/rastreo-guias') }}">Rastreo de Guias</a>
            </div>
        </div>
    </li>
    @endif

    {{-- ADMIN CRM - Visible para todos EXCEPTO t1 --}}
    @if (!empty(\Auth::User()->tipo_usuario) && \Auth::User()->tipo_usuario == 'admin')
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Admin CRM
    </div>

    <li id="cajaChica" class="nav-item">
        <a class="nav-link" href="{{ url('sb-admin/caja') }}">
            <i class="fas fa-cash-register"></i>
            <span>Caja chica</span></a>
    </li>

    <li id="cotizador_m" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCotizador"
            aria-expanded="true" aria-controls="collapseCotizador">
            <i class="fas fa-calculator"></i>
            <span>Cotizador</span>
        </a>
        <div id="collapseCotizador" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo de cotizaciones:</h6>
                <a id="ver_cotizaciones" class="collapse-item" href="{{ url('sb-admin/cotizaciones') }}">Listado de
                    cotizaciones</a>
                <a id="genera_cotizacion" class="collapse-item"
                    href="{{ url('sb-admin/genera-cotizacion') }}">COTIZAR</a>
            </div>
        </div>
    </li>

    <li id="ventas_m" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVentas" aria-expanded="true"
            aria-controls="collapseVentas">
            <i class="fas fa-dollar-sign"></i>
            <span>Ventas</span>
        </a>
        <div id="collapseVentas" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo de ventas:</h6>
                <a id="ver_ventas" class="collapse-item" href="{{ url('sb-admin/ventas') }}">Listado de ventas</a>
            </div>
        </div>
    </li>

    {{-- Ventas gdl --}}
    @if (!empty(\Auth::User()->tipo_usuario) && (\Auth::User()->id == 26 || \Auth::User()->id == 25 || \Auth::User()->id == 16))
    <li id="inventarioSuc" class="nav-item">
        <a class="nav-link" href="{{ url('sb-admin/inventarioSuc') }}">
            <i class="fas fa-boxes"></i>
            <span>Inventario Sucursal</span></a>
    </li>
    @endif

    @if (!empty(\Auth::User()->tipo_usuario) && \Auth::User()->tipo_usuario == 'admin')
    <li id="clientes_prospectos" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes"
            aria-expanded="true" aria-controls="collapseClientes">
            <i class="fas fa-users"></i>
            <span>Clientes</span>
        </a>
        <div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo de clientes:</h6>
                <a id="todos_articulos_menu" class="collapse-item" href="{{ url('sb-admin/clientes') }}">Todos
                    los clientes</a>
            </div>
        </div>
    </li>

    <li id="item_usuarios" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="true" aria-controls="collapseUsuarios">
            <i class="fas fa-users-cog"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo de usuarios:</h6>
                <a id="todos_usuarios_menu" class="collapse-item" href="{{ url('sb-admin/usuarios') }}">Todos
                    los usuarios</a>
                <a id="registros_usuarios_menu" class="collapse-item"
                    href="{{ url('sb-admin/registros-usuarios') }}">Registros de usuarios</a>
            </div>
        </div>
    </li>

    <li id="tools" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHerramientas"
            aria-expanded="true" aria-controls="collapseHerramientas">
            <i class="fas fa-toolbox"></i>
            <span>Herramientas</span>
        </a>
        <div id="collapseHerramientas" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Herramientas:</h6>
                <a id="todos_articulos_menu" class="collapse-item" href="{{ url('sb-admin/codificar') }}">Codificar
                    base64</a>
            </div>
        </div>
    </li>
    @endif

    @endif {{-- Cierra el If general de T1 --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>