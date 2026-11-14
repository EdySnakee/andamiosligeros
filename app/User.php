<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tipo_usuario', 'estatus',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ROL_ADMIN = 'admin';
    const ROL_VENDEDOR = 'v1';
    const ROL_TALLER = 't1';

    /**
     * Devuelve los roles disponibles para asignar en el sistema.
     *
     * @return array
     */
    public static function getRolesDisponibles()
    {
        return [
            self::ROL_ADMIN    => 'Administrador',
            self::ROL_VENDEDOR => 'Vendedor',
            self::ROL_TALLER   => 'Taller',
        ];
    }

    /**
     * Verifica si el usuario es Administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->tipo_usuario === self::ROL_ADMIN;
    }

    /**
     * Verifica si el usuario es Vendedor (soporta códigos heredados v1, f1, n2).
     *
     * @return bool
     */
    public function isVendedor()
    {
        return in_array($this->tipo_usuario, [self::ROL_VENDEDOR, 'vendedor', 'f1', 'n2']);
    }

    /**
     * Verifica si el usuario es de Taller.
     *
     * @return bool
     */
    public function isTaller()
    {
        return in_array($this->tipo_usuario, [self::ROL_TALLER, 'taller']);
    }

    /**
     * Verifica si el usuario corresponde a un perfil de Sucursal.
     *
     * @return bool
     */
    public function isSucursal()
    {
        return $this->tipo_usuario === 'g1' || in_array($this->id, [16, 25, 26, 32]);
    }

    /**
     * Verifica si el usuario está activo.
     *
     * @return bool
     */
    public function isActivo()
    {
        return (int)$this->estatus === 1;
    }

    /**
     * Obtiene el nombre legible del rol del usuario.
     *
     * @return string
     */
    public function getNombreRolAttribute()
    {
        if ($this->isAdmin()) {
            return 'Administrador';
        }
        if ($this->isVendedor()) {
            return 'Vendedor';
        }
        if ($this->isTaller()) {
            return 'Taller';
        }
        if ($this->isSucursal()) {
            return 'Sucursal';
        }
        return !empty($this->tipo_usuario) ? ucfirst($this->tipo_usuario) : 'Sin rol';
    }

    /**
     * Catálogo de vistas permitidas para Accesos Rápidos según el rol actual del usuario.
     *
     * @return array
     */
    public function getCatalogoAccesosRapidos()
    {
        $esAdmin = $this->isAdmin();
        $esVendedor = $this->isVendedor();
        $esTaller = $this->isTaller();
        $esSucursal = $this->isSucursal();

        $catalogo = [];

        if ($esAdmin || $esVendedor || $esTaller) {
            $catalogo[] = [
                'key'   => 'cotizar',
                'label' => 'Cotizar',
                'full'  => 'Cotizar',
                'url'   => url('sb-admin/genera-cotizacion'),
                'match' => '/sb-admin/genera-cotizacion',
                'icon'  => 'fas fa-plus-circle',
            ];
            $catalogo[] = [
                'key'   => 'cotizaciones',
                'label' => 'Cotizaciones',
                'full'  => 'Listado de Cotizaciones',
                'url'   => url('sb-admin/cotizaciones'),
                'match' => '/sb-admin/cotizaciones',
                'icon'  => 'fas fa-file-invoice-dollar',
            ];
            $catalogo[] = [
                'key'   => 'ventas',
                'label' => 'Ventas',
                'full'  => 'Listado de Ventas',
                'url'   => url('sb-admin/ventas'),
                'match' => '/sb-admin/ventas',
                'icon'  => 'fas fa-dollar-sign',
            ];
            $catalogo[] = [
                'key'   => 'formato_entrega',
                'label' => 'F. Entrega',
                'full'  => 'Formato de Entrega',
                'url'   => route('app_formatos_entrega'),
                'match' => '/sb-admin/formatos/entrega',
                'icon'  => 'fas fa-truck',
            ];
            $catalogo[] = [
                'key'   => 'formato_cambio',
                'label' => 'F. Cambio',
                'full'  => 'Cambio de Producto',
                'url'   => route('app_formatos_cambio'),
                'match' => '/sb-admin/formatos/cambio-producto',
                'icon'  => 'fas fa-exchange-alt',
            ];
            $catalogo[] = [
                'key'   => 'ordenes_taller',
                'label' => 'Taller',
                'full'  => 'Órdenes de Taller',
                'url'   => url('sb-admin/ordenes-taller'),
                'match' => '/sb-admin/ordenes-taller',
                'icon'  => 'fas fa-tools',
            ];
            $catalogo[] = [
                'key'   => 'rastreo_guias',
                'label' => 'Guías',
                'full'  => 'Rastreo de Guías',
                'url'   => url('sb-admin/rastreo-guias'),
                'match' => '/sb-admin/rastreo-guias',
                'icon'  => 'fas fa-shipping-fast',
            ];
        }

        if ($esAdmin || $esVendedor) {
            $catalogo[] = [
                'key'   => 'clientes',
                'label' => 'Clientes',
                'full'  => 'Todos los Clientes',
                'url'   => url('sb-admin/clientes'),
                'match' => '/sb-admin/clientes',
                'icon'  => 'fas fa-users',
            ];
        }

        if ($esAdmin || $esTaller) {
            $catalogo[] = [
                'key'   => 'inventario',
                'label' => 'Inventario',
                'full'  => 'Inventario General',
                'url'   => url('sb-admin/inventario'),
                'match' => '/sb-admin/inventario',
                'icon'  => 'fas fa-boxes',
            ];
            $catalogo[] = [
                'key'   => 'embarques',
                'label' => 'Embarques',
                'full'  => 'Órdenes de Embarque',
                'url'   => url('sb-admin/ordenes-embarque'),
                'match' => '/sb-admin/ordenes-embarque',
                'icon'  => 'fas fa-truck-loading',
            ];
        }

        if ($esAdmin || $esSucursal) {
            $catalogo[] = [
                'key'   => 'inventario_suc',
                'label' => 'Inv. Sucursal',
                'full'  => 'Inventario Sucursal',
                'url'   => url('sb-admin/inventarioSuc'),
                'match' => '/sb-admin/inventarioSuc',
                'icon'  => 'fas fa-warehouse',
            ];
        }

        if ($esAdmin) {
            $catalogo[] = [
                'key'   => 'productos',
                'label' => 'Productos',
                'full'  => 'Catálogo de Productos',
                'url'   => url('sb-admin/productos'),
                'match' => '/sb-admin/productos',
                'icon'  => 'fas fa-cube',
            ];
            $catalogo[] = [
                'key'   => 'agregar_producto',
                'label' => '+ Producto',
                'full'  => 'Agregar Producto',
                'url'   => url('sb-admin/agregar-producto'),
                'match' => '/sb-admin/agregar-producto',
                'icon'  => 'fas fa-plus-square',
            ];
            $catalogo[] = [
                'key'   => 'tienda',
                'label' => 'Tienda Web',
                'full'  => 'Tienda en Línea',
                'url'   => url('sb-admin/productos-tienda'),
                'match' => '/sb-admin/productos-tienda',
                'icon'  => 'fas fa-store',
            ];
            $catalogo[] = [
                'key'   => 'ajustes_tienda',
                'label' => 'Ajustes Tienda',
                'full'  => 'Ajustes de Tienda',
                'url'   => url('sb-admin/ajustes_tienda'),
                'match' => '/sb-admin/ajustes_tienda',
                'icon'  => 'fas fa-sliders-h',
            ];
            $catalogo[] = [
                'key'   => 'promociones',
                'label' => 'Promociones',
                'full'  => 'Promociones',
                'url'   => url('sb-admin/all-promos'),
                'match' => '/sb-admin/all-promos',
                'icon'  => 'fas fa-percent',
            ];
            $catalogo[] = [
                'key'   => 'blog',
                'label' => 'Blog',
                'full'  => 'Artículos del Blog',
                'url'   => url('sb-admin/articulos'),
                'match' => '/sb-admin/articulos',
                'icon'  => 'far fa-newspaper',
            ];
            $catalogo[] = [
                'key'   => 'agregar_blog',
                'label' => '+ Artículo',
                'full'  => 'Agregar Artículo',
                'url'   => url('sb-admin/agregar-articulos'),
                'match' => '/sb-admin/agregar-articulos',
                'icon'  => 'fas fa-pen-nib',
            ];
            $catalogo[] = [
                'key'   => 'est_ventas',
                'label' => 'Est. Ventas',
                'full'  => 'Estadísticas de Ventas',
                'url'   => url('sb-admin/est-ventas'),
                'match' => '/sb-admin/est-ventas',
                'icon'  => 'fas fa-chart-line',
            ];
            $catalogo[] = [
                'key'   => 'est_cotizaciones',
                'label' => 'Est. Cotiz.',
                'full'  => 'Estadísticas de Cotizaciones',
                'url'   => url('sb-admin/est-cotizaciones'),
                'match' => '/sb-admin/est-cotizaciones',
                'icon'  => 'fas fa-chart-bar',
            ];
            $catalogo[] = [
                'key'   => 'caja_chica',
                'label' => 'Caja Chica',
                'full'  => 'Caja Chica',
                'url'   => url('sb-admin/caja'),
                'match' => '/sb-admin/caja',
                'icon'  => 'fas fa-cash-register',
            ];
            $catalogo[] = [
                'key'   => 'usuarios',
                'label' => 'Usuarios',
                'full'  => 'Todos los Usuarios',
                'url'   => url('sb-admin/usuarios'),
                'match' => '/sb-admin/usuarios',
                'icon'  => 'fas fa-users-cog',
            ];
            $catalogo[] = [
                'key'   => 'registros_usuarios',
                'label' => 'Bitácora Usr.',
                'full'  => 'Registros de Usuarios',
                'url'   => url('sb-admin/registros-usuarios'),
                'match' => '/sb-admin/registros-usuarios',
                'icon'  => 'fas fa-user-clock',
            ];
            $catalogo[] = [
                'key'   => 'codificar',
                'label' => 'Base64',
                'full'  => 'Codificar Base64',
                'url'   => url('sb-admin/codificar'),
                'match' => '/sb-admin/codificar',
                'icon'  => 'fas fa-code',
            ];
        }

        return $catalogo;
    }

    /**
     * Semilla inicial (4 por defecto) según el rol del usuario.
     *
     * @return array
     */
    public function getDefaultsAccesosRapidos()
    {
        if ($this->isTaller()) {
            $defaults = ['ordenes_taller', 'inventario', 'formato_entrega', 'embarques'];
        } elseif ($this->isVendedor() || $this->isAdmin()) {
            $defaults = ['cotizar', 'cotizaciones', 'ventas', 'formato_entrega'];
        } else {
            $defaults = ['inventario_suc'];
        }

        $permitidas = [];
        foreach ($this->getCatalogoAccesosRapidos() as $item) {
            $permitidas[$item['key']] = true;
        }

        return array_values(array_filter($defaults, function ($k) use ($permitidas) {
            return isset($permitidas[$k]);
        }));
    }

    /**
     * Indica si la columna accesos_rapidos ya existe en la tabla cargada (sin consultas extra).
     *
     * @return bool
     */
    public function hasAccesosRapidosColumn()
    {
        return array_key_exists('accesos_rapidos', $this->getAttributes());
    }

    /**
     * Indica si el usuario ya personalizó explícitamente sus frecuentes en BD (incluyendo dejarlos en []).
     *
     * @return bool
     */
    public function hasAccesosRapidosPersonalizados()
    {
        if (!$this->hasAccesosRapidosColumn()) {
            return false;
        }
        return $this->accesos_rapidos !== null;
    }

    /**
     * Filtra y deduplica un arreglo de claves contra el catálogo permitido para este usuario.
     *
     * @param array $claves
     * @return array
     */
    public function filtrarClavesAccesosRapidos(array $claves)
    {
        $permitidas = [];
        foreach ($this->getCatalogoAccesosRapidos() as $item) {
            $permitidas[$item['key']] = true;
        }

        $vistos = [];
        $filtradas = [];
        foreach ($claves as $clave) {
            if (!is_string($clave) || !isset($permitidas[$clave]) || isset($vistos[$clave])) {
                continue;
            }
            $vistos[$clave] = true;
            $filtradas[] = $clave;
        }

        return $filtradas;
    }

    /**
     * Devuelve la lista resuelta para el usuario: sus claves guardadas (0 a 4) si ya personalizó,
     * o los 4 por defecto de su rol si nunca ha editado sus frecuentes (NULL).
     *
     * @return array
     */
    public function getAccesosRapidosResueltos()
    {
        if ($this->hasAccesosRapidosPersonalizados()) {
            $decodificado = json_decode($this->accesos_rapidos, true);
            if (is_array($decodificado)) {
                return array_slice($this->filtrarClavesAccesosRapidos($decodificado), 0, 4);
            }
        }

        return array_slice($this->getDefaultsAccesosRapidos(), 0, 4);
    }
}
