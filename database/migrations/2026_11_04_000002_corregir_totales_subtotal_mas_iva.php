<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CorregirTotalesSubtotalMasIva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('cotizaciones')) {
            // En la base de datos de Andamios Ligeros, subtotal ya representa la base gravable
            // (suma de partidas - descuento + envío), por lo que el total es exactamente subtotal + iva.
            DB::statement("
                UPDATE cotizaciones 
                SET total = ROUND(subtotal + iva, 2)
                WHERE ABS(total - (subtotal + iva)) > 0.05
            ");
        }

        if (Schema::hasTable('ventas')) {
            // Igualmente en ventas, subtotal incluye los envíos y el total es subtotal + iva.
            DB::statement("
                UPDATE ventas 
                SET total = ROUND(subtotal + iva, 2)
                WHERE ABS(total - (subtotal + iva)) > 0.05
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
