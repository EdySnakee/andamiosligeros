@php
    $usrMenu = \Auth::user();
    $esAdminMenu = $usrMenu && $usrMenu->isAdmin();
    $esVendedorMenu = $usrMenu && $usrMenu->isVendedor();
    $esTallerMenu = $usrMenu && $usrMenu->isTaller();
    $esSucursalMenu = $usrMenu && $usrMenu->isSucursal();

    $catalogoAccesosMenu = $usrMenu ? $usrMenu->getCatalogoAccesosRapidos() : [];
    $defaultsRolMenu = $usrMenu ? $usrMenu->getDefaultsAccesosRapidos() : [];
    $accesosPersonalizadosMenu = ($usrMenu && $usrMenu->hasAccesosRapidosPersonalizados())
        ? $usrMenu->getAccesosRapidosResueltos()
        : null;
    $sinFrecuentesInicialMenu = is_array($accesosPersonalizadosMenu) && count($accesosPersonalizadosMenu) === 0;
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar"
    data-user-id="{{ $usrMenu ? $usrMenu->id : 0 }}"
    data-catalogo-accesos="{{ json_encode($catalogoAccesosMenu) }}"
    data-defaults-accesos="{{ json_encode($defaultsRolMenu) }}"
    data-saved-accesos="{{ $accesosPersonalizadosMenu !== null ? json_encode($accesosPersonalizadosMenu) : 'null' }}"
    data-url-guardar-accesos="{{ route('app_perfil_accesos_rapidos') }}">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ $esTallerMenu ? url('sb-admin/ordenes-taller') : url('sb-admin/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img width="32px" src="{{ url('script/icono-sistema.png') }}" alt="">
        </div>
        <div class="sidebar-brand-text mx-2" style="color: #0848af;">
            <div>ANDAMIOS</div><small>LIGEROS</small>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    @if (\Auth::check())

        {{-- 1. DASHBOARD DIRECTO (1 CLIC) --}}
        @if (!$esTallerMenu)
        <li id="dashboard" class="nav-item">
            <a class="nav-link nav-link-directo" href="{{ url('sb-admin/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @endif

        {{-- 2. ACCESOS RÁPIDOS VINCULADOS A LA CUENTA (0 A 4 FIJADOS, OCULTA SI QUEDA EN 0) --}}
        <hr class="sidebar-divider my-1 grupo-frecuentes-sidebar {{ $sinFrecuentesInicialMenu ? 'd-none' : '' }}">
        <div class="sidebar-heading sidebar-heading-rapidos grupo-frecuentes-sidebar {{ $sinFrecuentesInicialMenu ? 'd-none' : '' }}" title="Accesos frecuentes fijados en tu cuenta (clic directo)">
            <span><i class="fas fa-bolt text-warning mr-1"></i>Frecuentes</span>
        </div>
        <div id="contenedor-accesos-rapidos-sidebar" class="grupo-frecuentes-sidebar {{ $sinFrecuentesInicialMenu ? 'd-none' : '' }}">
            {{-- Se hidrata instantáneamente vía JS según las preferencias de la cuenta --}}
        </div>

        <hr class="sidebar-divider my-1">
        <div class="sidebar-heading">
            Módulos
        </div>

        {{-- GRUPO 1: COMERCIAL (Cotizador, Ventas, Clientes, Estadísticas) --}}
        @if ($esAdminMenu || $esVendedorMenu || $esTallerMenu)
        <li id="cotizador_m" class="nav-item nav-item-grupo">
            <a class="nav-link collapsed nav-link-con-submenu" href="#" data-toggle="collapse" data-target="#collapseComercial"
                aria-expanded="false" aria-controls="collapseComercial">
                <i class="fas fa-briefcase"></i>
                <span>Comercial</span>
            </a>
            <div id="collapseComercial" class="collapse" aria-labelledby="headingComercial" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Cotizaciones y Ventas:</h6>
                    <a id="genera_cotizacion" class="collapse-item item-menu-pinneable" data-menu-key="cotizar" href="{{ url('sb-admin/genera-cotizacion') }}">
                        <span><i class="fas fa-plus-circle mr-1 text-primary"></i> Cotizar</span>
                        <span class="btn-pin-acceso" data-key="cotizar" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="ver_cotizaciones" class="collapse-item item-menu-pinneable" data-menu-key="cotizaciones" href="{{ url('sb-admin/cotizaciones') }}">
                        <span><i class="fas fa-file-invoice-dollar mr-1"></i> Cotizaciones</span>
                        <span class="btn-pin-acceso" data-key="cotizaciones" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="ver_ventas" class="collapse-item item-menu-pinneable" data-menu-key="ventas" href="{{ url('sb-admin/ventas') }}">
                        <span><i class="fas fa-dollar-sign mr-1"></i> Ventas</span>
                        <span class="btn-pin-acceso" data-key="ventas" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    @if ($esAdminMenu || $esVendedorMenu)
                    <a id="todos_clientes_menu" class="collapse-item item-menu-pinneable" data-menu-key="clientes" href="{{ url('sb-admin/clientes') }}">
                        <span><i class="fas fa-users mr-1"></i> Clientes</span>
                        <span class="btn-pin-acceso" data-key="clientes" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    @endif
                    @if ($esAdminMenu)
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Estadísticas:</h6>
                    <a id="ver_est_ventas" class="collapse-item item-menu-pinneable" data-menu-key="est_ventas" href="{{ url('sb-admin/est-ventas') }}">
                        <span><i class="fas fa-chart-line mr-1"></i> Est. de Ventas</span>
                        <span class="btn-pin-acceso" data-key="est_ventas" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="ver_est_cotizaciones" class="collapse-item item-menu-pinneable" data-menu-key="est_cotizaciones" href="{{ url('sb-admin/est-cotizaciones') }}">
                        <span><i class="fas fa-chart-bar mr-1"></i> Est. Cotizaciones</span>
                        <span class="btn-pin-acceso" data-key="est_cotizaciones" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    @endif
                </div>
            </div>
        </li>

        {{-- GRUPO 2: FORMATOS (Entrega y Cambio de Producto) --}}
        <li id="formatos_m" class="nav-item nav-item-grupo">
            <a class="nav-link collapsed nav-link-con-submenu" href="#" data-toggle="collapse" data-target="#collapseFormatos"
                aria-expanded="false" aria-controls="collapseFormatos">
                <i class="fas fa-file-signature"></i>
                <span>Formatos</span>
            </a>
            <div id="collapseFormatos" class="collapse" aria-labelledby="headingFormatos" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Formatos de control:</h6>
                    <a id="formato_entrega_menu" class="collapse-item item-menu-pinneable" data-menu-key="formato_entrega" href="{{ route('app_formatos_entrega') }}">
                        <span><i class="fas fa-truck mr-1"></i> Formato de Entrega</span>
                        <span class="btn-pin-acceso" data-key="formato_entrega" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="formato_cambio_menu" class="collapse-item item-menu-pinneable" data-menu-key="formato_cambio" href="{{ route('app_formatos_cambio') }}">
                        <span><i class="fas fa-exchange-alt mr-1"></i> Cambio de Producto</span>
                        <span class="btn-pin-acceso" data-key="formato_cambio" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                </div>
            </div>
        </li>
        @endif

        {{-- GRUPO 3: OPERACIÓN Y ALMACÉN (Taller, Guías, Inventario, Embarques, Inv. Sucursal) --}}
        @if ($esAdminMenu || $esTallerMenu || $esVendedorMenu || $esSucursalMenu)
        <li id="taller" class="nav-item nav-item-grupo">
            <a class="nav-link collapsed nav-link-con-submenu" href="#" data-toggle="collapse" data-target="#collapseOperacion"
                aria-expanded="false" aria-controls="collapseOperacion">
                <i class="fas fa-Hard-Hat fa-tools"></i>
                <span>Operación</span>
            </a>
            <div id="collapseOperacion" class="collapse" aria-labelledby="headingOperacion" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($esAdminMenu || $esTallerMenu || $esVendedorMenu)
                    <h6 class="collapse-header">Taller y Envíos:</h6>
                    <a id="ver_ordenes_taller" class="collapse-item item-menu-pinneable" data-menu-key="ordenes_taller" href="{{ url('sb-admin/ordenes-taller') }}">
                        <span><i class="fas fa-tools mr-1"></i> Órdenes de Taller</span>
                        <span class="btn-pin-acceso" data-key="ordenes_taller" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="rastreo_guias" class="collapse-item item-menu-pinneable" data-menu-key="rastreo_guias" href="{{ url('sb-admin/rastreo-guias') }}">
                        <span><i class="fas fa-shipping-fast mr-1"></i> Rastreo de Guías</span>
                        <span class="btn-pin-acceso" data-key="rastreo_guias" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    @endif

                    @if ($esAdminMenu || $esTallerMenu || $esSucursalMenu)
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Almacén e Inventario:</h6>
                    @endif

                    @if ($esAdminMenu || $esTallerMenu)
                    <a id="inventario_menu" class="collapse-item item-menu-pinneable" data-menu-key="inventario" href="{{ url('sb-admin/inventario') }}">
                        <span><i class="fas fa-boxes mr-1"></i> Inventario General</span>
                        <span class="btn-pin-acceso" data-key="inventario" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="ordenes_embarque_menu" class="collapse-item item-menu-pinneable" data-menu-key="embarques" href="{{ url('sb-admin/ordenes-embarque') }}">
                        <span><i class="fas fa-truck-loading mr-1"></i> Órdenes de Embarque</span>
                        <span class="btn-pin-acceso" data-key="embarques" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    @endif

                    @if ($esAdminMenu || $esSucursalMenu)
                    <a id="inventarioSuc" class="collapse-item item-menu-pinneable" data-menu-key="inventario_suc" href="{{ url('sb-admin/inventarioSuc') }}">
                        <span><i class="fas fa-warehouse mr-1"></i> Inventario Sucursal</span>
                        <span class="btn-pin-acceso" data-key="inventario_suc" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    @endif
                </div>
            </div>
        </li>
        @endif

        {{-- HORAS EXTRA (Acceso para todos los roles autenticados) --}}
        <li id="horas_extra_m" class="nav-item">
            <a class="nav-link nav-link-directo" href="{{ route('app_horas_extra') }}">
                <i class="fas fa-fw fa-business-time"></i>
                <span>Horas extra</span>
            </a>
        </li>

        {{-- GRUPO 4: CATÁLOGO Y SITIO WEB (Productos, Tienda en Línea, Promociones, Blog) --}}
        @if ($esAdminMenu)
        <li id="productos_m" class="nav-item nav-item-grupo">
            <a class="nav-link collapsed nav-link-con-submenu" href="#" data-toggle="collapse" data-target="#collapseCatalogoWeb"
                aria-expanded="false" aria-controls="collapseCatalogoWeb">
                <i class="fas fa-store"></i>
                <span>Catálogo y Web</span>
            </a>
            <div id="collapseCatalogoWeb" class="collapse" aria-labelledby="headingCatalogoWeb" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Catálogo de Productos:</h6>
                    <a id="ver_productos" class="collapse-item item-menu-pinneable" data-menu-key="productos" href="{{ url('sb-admin/productos') }}">
                        <span><i class="fas fa-cube mr-1"></i> Listado de productos</span>
                        <span class="btn-pin-acceso" data-key="productos" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="add_producto" class="collapse-item item-menu-pinneable" data-menu-key="agregar_producto" href="{{ url('sb-admin/agregar-producto') }}">
                        <span><i class="fas fa-plus-square mr-1"></i> Agregar producto</span>
                        <span class="btn-pin-acceso" data-key="agregar_producto" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>

                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Tienda en Línea y Promos:</h6>
                    <a id="all_tienda_menu" class="collapse-item item-menu-pinneable" data-menu-key="tienda" href="{{ url('sb-admin/productos-tienda') }}">
                        <span><i class="fas fa-shopping-bag mr-1"></i> Productos Tienda</span>
                        <span class="btn-pin-acceso" data-key="tienda" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="ajustes_tienda" class="collapse-item item-menu-pinneable" data-menu-key="ajustes_tienda" href="{{ url('sb-admin/ajustes_tienda') }}">
                        <span><i class="fas fa-cog mr-1"></i> Ajustes de Tienda</span>
                        <span class="btn-pin-acceso" data-key="ajustes_tienda" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="all_promo_menu" class="collapse-item item-menu-pinneable" data-menu-key="promociones" href="{{ url('sb-admin/all-promos') }}">
                        <span><i class="fas fa-percent mr-1"></i> Promociones</span>
                        <span class="btn-pin-acceso" data-key="promociones" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>

                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Blog:</h6>
                    <a id="todos_articulos_menu" class="collapse-item item-menu-pinneable" data-menu-key="blog" href="{{ url('sb-admin/articulos') }}">
                        <span><i class="far fa-newspaper mr-1"></i> Todos los artículos</span>
                        <span class="btn-pin-acceso" data-key="blog" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="agregar_articulos_menu" class="collapse-item item-menu-pinneable" data-menu-key="agregar_blog" href="{{ url('sb-admin/agregar-articulos') }}">
                        <span><i class="fas fa-pen-nib mr-1"></i> Agregar artículo</span>
                        <span class="btn-pin-acceso" data-key="agregar_blog" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                </div>
            </div>
        </li>

        {{-- GRUPO 5: ADMINISTRACIÓN CRM (Caja Chica, Usuarios, Herramientas) --}}
        <li id="item_usuarios" class="nav-item nav-item-grupo">
            <a class="nav-link collapsed nav-link-con-submenu" href="#" data-toggle="collapse" data-target="#collapseAdminCrm"
                aria-expanded="false" aria-controls="collapseAdminCrm">
                <i class="fas fa-user-shield"></i>
                <span>Administración</span>
            </a>
            <div id="collapseAdminCrm" class="collapse" aria-labelledby="headingAdminCrm" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Finanzas y Usuarios:</h6>
                    <a id="cajaChica" class="collapse-item item-menu-pinneable" data-menu-key="caja_chica" href="{{ url('sb-admin/caja') }}">
                        <span><i class="fas fa-cash-register mr-1"></i> Caja chica</span>
                        <span class="btn-pin-acceso" data-key="caja_chica" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="todos_usuarios_menu" class="collapse-item item-menu-pinneable" data-menu-key="usuarios" href="{{ url('sb-admin/usuarios') }}">
                        <span><i class="fas fa-users-cog mr-1"></i> Todos los usuarios</span>
                        <span class="btn-pin-acceso" data-key="usuarios" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <a id="registros_usuarios_menu" class="collapse-item item-menu-pinneable" data-menu-key="registros_usuarios" href="{{ url('sb-admin/registros-usuarios') }}">
                        <span><i class="fas fa-user-clock mr-1"></i> Registros de usuarios</span>
                        <span class="btn-pin-acceso" data-key="registros_usuarios" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Herramientas:</h6>
                    <a id="codificar_menu" class="collapse-item item-menu-pinneable" data-menu-key="codificar" href="{{ url('sb-admin/codificar') }}">
                        <span><i class="fas fa-code mr-1"></i> Codificar base64</span>
                        <span class="btn-pin-acceso" data-key="codificar" title="Fijar / desfijar en Frecuentes"><i class="fas fa-thumbtack"></i></span>
                    </a>
                </div>
            </div>
        </li>
        @endif

    @endif

    <hr class="sidebar-divider sidebar-divider-bottom-toggler d-none d-md-block my-2">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="sidebar-toggler-container text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Desplegar / contraer menú"></button>
    </div>

</ul>
