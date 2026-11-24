<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateHorasExtraTables extends Migration
{
    /**
     * Crea las tablas para el módulo de solicitudes, sesiones y auditoría de horas extra.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('horas_extra_solicitudes')) {
            Schema::create('horas_extra_solicitudes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->index();
                $table->date('fecha')->index();
                $table->time('hora_inicio_prevista')->nullable();
                $table->decimal('horas_estimadas', 5, 2);
                $table->decimal('horas_autorizadas', 5, 2)->nullable();
                $table->string('modalidad', 20);
                $table->text('motivo');
                $table->text('entregable')->nullable();
                $table->string('referencia_tipo', 30)->nullable();
                $table->string('referencia_folio', 100)->nullable();
                $table->string('estatus', 20)->default('programada')->index();
                $table->integer('aprobada_por')->unsigned()->nullable();
                $table->dateTime('aprobada_at')->nullable();
                $table->text('comentario_aprobacion')->nullable();
                $table->dateTime('inicio_at')->nullable();
                $table->dateTime('fin_at')->nullable();
                $table->integer('cerrada_por')->unsigned()->nullable();
                $table->text('resumen_trabajo')->nullable();
                $table->text('evidencias')->nullable();
                $table->integer('minutos_declarados')->nullable();
                $table->integer('minutos_activos')->nullable();
                $table->integer('minutos_validados')->nullable();
                $table->integer('validada_por')->unsigned()->nullable();
                $table->dateTime('validada_at')->nullable();
                $table->text('comentario_validacion')->nullable();
                $table->boolean('acepta_aviso')->default(0);
                $table->string('aviso_version', 20)->nullable();
                $table->dateTime('aviso_aceptado_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'estatus'], 'idx_he_sol_user_estatus');
            });
        }

        if (!Schema::hasTable('horas_extra_eventos')) {
            Schema::create('horas_extra_eventos', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('solicitud_id')->unsigned()->index();
                $table->integer('user_id')->unsigned()->index();
                $table->string('tipo', 20);
                $table->string('ruta', 255)->nullable();
                $table->string('ip', 64)->nullable();
                $table->string('user_agent', 255)->nullable();
                $table->decimal('latitud', 10, 7)->nullable();
                $table->decimal('longitud', 10, 7)->nullable();
                $table->integer('precision_m')->nullable();
                $table->string('ubicacion_estado', 20)->nullable();
                $table->dateTime('created_at')->index();

                $table->index(['solicitud_id', 'tipo', 'created_at'], 'idx_he_ev_sol_tipo_fecha');
            });
        }
    }

    /**
     * Revierte las tablas de horas extra.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horas_extra_eventos');
        Schema::dropIfExists('horas_extra_solicitudes');
    }
}

