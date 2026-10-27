<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalisisComercialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leads_mensuales')) {
            Schema::create('leads_mensuales', function (Blueprint $table) {
                $table->increments('id');
                $table->string('mes', 7)->unique(); // Formato YYYY-MM
                $table->unsignedInteger('leads')->default(0);
                $table->string('notas', 255)->nullable();
                $table->unsignedInteger('id_usuario')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('config_analisis_comercial')) {
            Schema::create('config_analisis_comercial', function (Blueprint $table) {
                $table->string('clave', 64)->primary();
                $table->string('valor', 255);
                $table->string('descripcion', 255)->nullable();
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
        Schema::dropIfExists('leads_mensuales');
        Schema::dropIfExists('config_analisis_comercial');
    }
}
