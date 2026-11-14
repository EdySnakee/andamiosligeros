<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFormatosAndamiosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('formatos_entrega')) {
            Schema::create('formatos_entrega', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_cotizacion')->unsigned()->nullable()->index();
                $table->integer('numero_entrega')->default(1);
                $table->string('folio_entrega', 50)->nullable()->index();
                $table->date('fecha')->nullable();
                $table->string('fecha_formato', 50)->nullable();
                $table->string('cliente', 255)->nullable();
                $table->string('telefono', 50)->nullable();
                $table->string('folio_cotizacion', 100)->nullable()->index();
                $table->string('vendedor', 150)->nullable();
                $table->text('observaciones')->nullable();
                $table->integer('id_usuario')->unsigned()->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('formatos_entrega_detalle')) {
            Schema::create('formatos_entrega_detalle', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_formato_entrega')->unsigned()->index();
                $table->integer('id_det_cotizacion')->unsigned()->nullable()->index();
                $table->integer('id_producto')->unsigned()->nullable();
                $table->text('nombre_producto');
                $table->decimal('cantidad', 10, 2)->default(1);
                $table->string('unidad', 20)->default('pzas');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('formatos_cambio')) {
            Schema::create('formatos_cambio', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_cotizacion')->unsigned()->nullable()->index();
                $table->string('folio_cambio', 50)->nullable()->index();
                $table->date('fecha')->nullable();
                $table->string('fecha_formato', 50)->nullable();
                $table->string('cliente', 255)->nullable();
                $table->string('telefono', 50)->nullable();
                $table->string('cotizacion_factura', 100)->nullable()->index();
                $table->string('vendedor', 150)->nullable();
                $table->string('forma_pago', 100)->nullable();
                $table->string('fecha_pago', 50)->nullable();
                $table->decimal('total_reconocido', 12, 2)->default(0);
                $table->decimal('total_sustitucion', 12, 2)->default(0);
                $table->decimal('diferencia_pagar', 12, 2)->default(0);
                $table->text('observaciones')->nullable();
                $table->integer('id_usuario')->unsigned()->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('formatos_cambio_detalle')) {
            Schema::create('formatos_cambio_detalle', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_formato_cambio')->unsigned()->index();
                $table->string('tipo_partida', 20)->index(); // 'entregado' | 'sustitucion'
                $table->integer('id_producto')->unsigned()->nullable();
                $table->text('nombre_producto');
                $table->decimal('cantidad', 10, 2)->default(1);
                $table->decimal('precio_unitario', 12, 2)->default(0); // Valor reconocido o precio unitario
                $table->decimal('importe', 12, 2)->default(0);
                $table->string('estado_observaciones', 255)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formatos_cambio_detalle');
        Schema::dropIfExists('formatos_cambio');
        Schema::dropIfExists('formatos_entrega_detalle');
        Schema::dropIfExists('formatos_entrega');
    }
}

