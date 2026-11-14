<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAccesosRapidosToUsersTable extends Migration
{
    /**
     * Verifica la existencia de la columna de forma compatible con MySQL 5.7/8 y Laravel 5.2.
     *
     * @return bool
     */
    private function hasAccesosRapidosColumn()
    {
        return count(DB::select("SHOW COLUMNS FROM `users` LIKE 'accesos_rapidos'")) > 0;
    }

    /**
     * Agrega la columna accesos_rapidos para vincular los frecuentes a cada cuenta de usuario.
     * Valor NULL = usuario aún no personaliza (usa defaults por rol); "[]" = 0 frecuentes.
     *
     * @return void
     */
    public function up()
    {
        if (!$this->hasAccesosRapidosColumn()) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('accesos_rapidos')->nullable()->after('sucursal_id');
            });
        }
    }

    /**
     * Revierte la migración eliminando la columna accesos_rapidos.
     *
     * @return void
     */
    public function down()
    {
        if ($this->hasAccesosRapidosColumn()) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('accesos_rapidos');
            });
        }
    }
}
