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
        if ($this->tipo_usuario === 'g1' || in_array($this->id, [16, 25, 26, 32])) {
            return 'Sucursal';
        }
        return !empty($this->tipo_usuario) ? ucfirst($this->tipo_usuario) : 'Sin rol';
    }
}
