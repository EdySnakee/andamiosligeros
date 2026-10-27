<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NormalizarModeloVallasProductosTienda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('productos_tienda')) {
            // Homogeneizar modelo a 'Valla' para todos los productos de categoría 'vallas'
            DB::table('productos_tienda')
                ->where('categoria', 'vallas')
                ->update(['modelo' => 'Valla']);

            // Corregir modelo_ref de la valla VRT-5 (id 59)
            DB::table('productos_tienda')
                ->where('id_product', 59)
                ->where('post_titulo', 'LIKE', '%VRT-5%')
                ->update(['modelo_ref' => 'VRT-5']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reversión no requerida
    }
}
