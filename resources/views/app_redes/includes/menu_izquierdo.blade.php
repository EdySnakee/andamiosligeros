<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ \Auth::check() && \Auth::user()->isTaller() ? url('sb-admin/ordenes-taller') : url('sb-admin/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img width="35px" src="{{ url('script/icono-sistema.png') }}" alt="">
        </div>
        <div class="sidebar-brand-text mx-3" style="color: #0848af;">
            <div>ANDAMIOS</div><small>LIGEROS</small>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    @if (\Auth::check())

        {{-- 1. DASHBOARD: Visible para Admin y Vendedor (Oculto para Taller) --}}
        @if (!\Auth::user()->isTaller())
        <li id="dashboard" class="nav-item">
            <a class="nav-link" href="{{ url('sb-admin/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @endif

        {{-- 2. INTERFASE WEB Y MARKETING: Solo Admin --}}
        @if (\Auth::user()->isAdmin())
        <hr class="sidebar-divider">
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
                    <a id="todos_articulos_menu" class="collapse-item" href="{{ url('sb-admin/articulos') }}">Todos los artículos</a>
                    <a id="agregar_articulos_menu" class="collapse-item" href="{{ url('sb-admin/agregar-articulos') }}">Agregar artículo</a>
                </div>
            </div>
        </li>

        <li id="tienda_m" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTienda" aria-expanded="true"
                aria-controls="collapseTienda">
                <i class="fas fa-store"></i>
                <span>Tienda en Línea</span>
            </a>
            <div id="collapseTienda" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Módulo Tienda en Línea:</h6>
                    <a id="all_tienda_menu" class="collapse-item" href="{{ url('sb-admin/productos-tienda') }}"><i class="fas fa-list"></i> Listado de productos</a>
                    <a id="ajustes_tienda" class="collapse-item" href="{{ url('sb-admin/ajustes_tienda') }}"><i class="fas fa-cog"></i> Ajustes</a>
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
                    <h6 class="collapse-header">Módulo Promociones:</h6>
                    <a id="all_promo_menu" class="collapse-item" href="{{ url('sb-admin/all-promos') }}"><i class="fas fa-list"></i> Listado de promociones</a>
                </div>
            </div>
        </li>

        <li id="estadisticas" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEstadistica"
                aria-expanded="true" aria-controls="collapseEstadistica">
                <i class="fas fa-chart-bar"></i>
                <span>Estadísticas</span>
            </a>
            <div id="collapseEstadistica" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Módulo de Estadísticas:</h6>
                    <a id="ver_est_ventas" class="collapse-item" href="{{ url('sb-admin/est-ventas') }}">Ventas</a>
                    <a id="ver_est_cotizaciones" class="collapse-item" href="{{ url('sb-admin/est-cotizaciones') }}">Cotizaciones</a>
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
                    <a id="ver_productos" class="collapse-item" href="{{ url('sb-admin/productos') }}">Listado de productos</a>
                    <a id="add_producto" class="collapse-item" href="{{ url('sb-admin/agregar-producto') }}">Agregar producto</a>
                </div>
            </div>
        </li>
        @endif

        {{-- 3. INVENTARIO: Visible para Admin y Taller --}}
        @if (\Auth::user()->isAdmin() || \Auth::user()->isTaller())
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Inventario
        </div>

        <li id="inventario" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventario"
                aria-expanded="true" aria-controls="collapseInventario">
                <i class="fas fa-boxes"></i>
                <span>Inventario</span>
            </a>
            <div id="collapseInventario" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Módulo Inventario:</h6>
                    <a id="inventario_menu" class="collapse-item" href="{{ url('sb-admin/inventario') }}"><i class="fas fa-boxes mr-1"></i> Inventario</a>
                    <a id="ordenes_embarque_menu" class="collapse-item" href="{{ url('sb-admin/ordenes-embarque') }}"><i class="fas fa-truck-loading mr-1"></i> Órdenes de embarque</a>
                </div>
            </div>
        </li>
        @endif

        {{-- 4. TALLER / PRODUCCIÓN: Visible para Admin, Taller y Vendedor --}}
        @if (\Auth::user()->isAdmin() || \Auth::user()->isTaller() || \Auth::user()->isVendedor())
        <hr class="sidebar-divider">
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
                    <h6 class="collapse-header">Órdenes de taller:</h6>
                    <a id="ver_ordenes_taller" class="collapse-item" href="{{ url('sb-admin/ordenes-taller') }}">Listado de órdenes</a>
                    <a id="rastreo_guias" class="collapse-item" href="{{ url('sb-admin/rastreo-guias') }}">Rastreo de Guías</a>
                </div>
            </div>
        </li>
        @endif

        {{-- 5. COMERCIAL (COTIZACIONES Y VENTAS): Visible para Admin, Vendedor y Taller --}}
        @if (\Auth::user()->isAdmin() || \Auth::user()->isVendedor() || \Auth::user()->isTaller())
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Comercial
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
                    <a id="ver_cotizaciones" class="collapse-item" href="{{ url('sb-admin/cotizaciones') }}">Listado de cotizaciones</a>
                    <a id="genera_cotizacion" class="collapse-item" href="{{ url('sb-admin/genera-cotizacion') }}">COTIZAR</a>
                </div>
            </div>
        </li>

        <li id="ventas_m" class="nav-item">
            <a class="nav-link" href="{{ url('sb-admin/ventas') }}">
                <i class="fas fa-dollar-sign"></i>
                <span>Ventas</span>
            </a>
        </li>
        @endif

        {{-- 6. CLIENTES: Visible para Admin y Vendedor --}}
        @if (\Auth::user()->isAdmin() || \Auth::user()->isVendedor())
        <li id="clientes_prospectos" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes"
                aria-expanded="true" aria-controls="collapseClientes">
                <i class="fas fa-users"></i>
                <span>Clientes</span>
            </a>
            <div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Módulo de clientes:</h6>
                    <a id="todos_articulos_menu" class="collapse-item" href="{{ url('sb-admin/clientes') }}">Todos los clientes</a>
                </div>
            </div>
        </li>
        @endif

        {{-- 7. INVENTARIO SUCURSAL: Sucursales y Admin --}}
        @if (\Auth::user()->isAdmin() || \Auth::user()->tipo_usuario == 'g1' || in_array(\Auth::user()->id, [16, 25, 26, 32]))
        <li id="inventarioSuc" class="nav-item">
            <a class="nav-link" href="{{ url('sb-admin/inventarioSuc') }}">
                <i class="fas fa-boxes"></i>
                <span>Inventario Sucursal</span>
            </a>
        </li>
        @endif

        {{-- 8. ADMINISTRACIÓN CRM: Exclusivo Admin --}}
        @if (\Auth::user()->isAdmin())
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Admin CRM
        </div>

        <li id="cajaChica" class="nav-item">
            <a class="nav-link" href="{{ url('sb-admin/caja') }}">
                <i class="fas fa-cash-register"></i>
                <span>Caja chica</span>
            </a>
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
                    <a id="todos_usuarios_menu" class="collapse-item" href="{{ url('sb-admin/usuarios') }}">Todos los usuarios</a>
                    <a id="registros_usuarios_menu" class="collapse-item" href="{{ url('sb-admin/registros-usuarios') }}">Registros de usuarios</a>
                </div>
            </div>
        </li>

        <li id="tools" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHerramientas"
                aria-expanded="true" aria-controls="collapseHerramientas">
                <i class="fas fa-toolbox"></i>
                <span>Herramientas</span>
            </a>
            <div id="collapseHerramientas" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Herramientas:</h6>
                    <a id="todos_articulos_menu" class="collapse-item" href="{{ url('sb-admin/codificar') }}">Codificar base64</a>
                </div>
            </div>
        </li>
        @endif

    @endif

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>