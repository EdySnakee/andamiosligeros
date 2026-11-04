<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RepararCotizacionesVentanaTemporal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('cotizaciones') && Schema::hasTable('detalle_cotizaciones')) {
            // Reparar cotizaciones de la ventana de hoy donde subtotal no incluía envío
            DB::statement("
                UPDATE cotizaciones c
                JOIN (
                    SELECT id_cotizacion, COALESCE(SUM(total_ind), 0) as items_sum
                    FROM detalle_cotizaciones
                    GROUP BY id_cotizacion
                ) t ON t.id_cotizacion = c.id_cotizacion
                SET 
                    c.subtotal = ROUND(GREATEST(0, t.items_sum - c.descuento_aplicado) + c.envio, 2),
                    c.iva = CASE WHEN c.iva > 0 THEN ROUND((GREATEST(0, t.items_sum - c.descuento_aplicado) + c.envio) * 0.16, 2) ELSE 0 END,
                    c.total = ROUND(
                        ROUND(GREATEST(0, t.items_sum - c.descuento_aplicado) + c.envio, 2) + 
                        CASE WHEN c.iva > 0 THEN ROUND((GREATEST(0, t.items_sum - c.descuento_aplicado) + c.envio) * 0.16, 2) ELSE 0 END, 
                        2
                    )
                WHERE c.envio > 0
                  AND c.fecha >= '2026-11-04'
                  AND c.subtotal < ROUND(GREATEST(0, t.items_sum - c.descuento_aplicado) + c.envio - 0.05, 2)
            ");
        }

        if (Schema::hasTable('ventas') && Schema::hasTable('cotizaciones')) {
            // Sincronizar ventas asociadas a esas cotizaciones si las hubiera
            DB::statement("
                UPDATE ventas v
                JOIN cotizaciones c ON c.id_cotizacion = v.id_cotizacion
                SET 
                    v.subtotal = ROUND(c.subtotal + COALESCE(v.envio_2, 0), 2),
                    v.iva = c.iva,
                    v.total = ROUND(c.subtotal + COALESCE(v.envio_2, 0) + c.iva, 2)
                WHERE v.fecha_venta >= '2026-11-04'
                  AND c.fecha >= '2026-11-04'
                  AND ABS(v.total - (c.subtotal + COALESCE(v.envio_2, 0) + c.iva)) > 0.05
            ");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Idempotente
    }
}

