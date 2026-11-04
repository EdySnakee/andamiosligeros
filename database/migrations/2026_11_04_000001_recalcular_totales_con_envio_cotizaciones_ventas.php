<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RecalcularTotalesConEnvioCotizacionesVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('cotizaciones')) {
            // Actualizar total en cotizaciones para que incluya envío e iva correctamente:
            // total = GREATEST(0, subtotal - descuento_aplicado) + envio + iva
            DB::statement("
                UPDATE cotizaciones 
                SET total = ROUND(GREATEST(0, subtotal - descuento_aplicado) + envio + iva, 2)
                WHERE envio > 0 
                  AND ABS(total - (GREATEST(0, subtotal - descuento_aplicado) + envio + iva)) > 0.05
            ");
        }

        if (Schema::hasTable('ventas')) {
            // Actualizar total en ventas para que incluya envio, envio_2 e iva correctamente:
            // total = GREATEST(0, subtotal - descuento_aplicado) + envio + COALESCE(envio_2, 0) + iva
            DB::statement("
                UPDATE ventas 
                SET total = ROUND(GREATEST(0, subtotal - descuento_aplicado) + envio + COALESCE(envio_2, 0) + iva, 2)
                WHERE (envio > 0 OR (envio_2 IS NOT NULL AND envio_2 > 0)) 
                  AND ABS(total - (GREATEST(0, subtotal - descuento_aplicado) + envio + COALESCE(envio_2, 0) + iva)) > 0.05
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
        // Reversión no requerida / idempotente
    }
}

